<?php

namespace Dialplan;

use Agi\Action\ExtensionAction;
use Agi\Action\ExternalNumberAction;
use Agi\Action\FriendCallAction;
use Agi\Action\ServiceAction;
use Agi\Agents\UserAgent;
use Agi\ChannelInfo;
use Agi\Wrapper;
use Helpers\EndpointResolver;
use Ivoz\Provider\Domain\Model\CompanyService\CompanyServiceInterface;
use Ivoz\Provider\Domain\Model\Feature\Feature;
use RouteHandlerAbstract;

class Users extends RouteHandlerAbstract
{
    /**
     * @var Wrapper
     */
    protected $agi;

    /**
     * @var ChannelInfo
     */
    protected $channelInfo;

    /**
     * @var EndpointResolver
     */
    protected $endpointResolver;

    /**
     * @var ServiceAction
     */
    protected $serviceAction;

    /**
     * @var ExtensionAction
     */
    protected $extensionAction;

    /**
     * @var FriendCallAction
     */
    protected $friendCallAction;

    /**
     * @var ExternalNumberAction
     */
    protected $externalNumberCallAction;

    /**
     * Users constructor.
     *
     * @param Wrapper $agi
     * @param ChannelInfo $channelInfo
     * @param EndpointResolver $endpointResolver
     * @param ServiceAction $serviceAction
     * @param ExtensionAction $extensionAction
     * @param FriendCallAction $friendCallAction
     * @param ExternalNumberAction $externalNumberCallAction
     */
    public function __construct(
        Wrapper $agi,
        ChannelInfo $channelInfo,
        EndpointResolver $endpointResolver,
        ServiceAction $serviceAction,
        ExtensionAction $extensionAction,
        FriendCallAction $friendCallAction,
        ExternalNumberAction $externalNumberCallAction
    ) {
        $this->agi = $agi;
        $this->channelInfo = $channelInfo;
        $this->endpointResolver = $endpointResolver;
        $this->serviceAction = $serviceAction;
        $this->extensionAction = $extensionAction;
        $this->friendCallAction = $friendCallAction;
        $this->externalNumberCallAction = $externalNumberCallAction;
    }

    /**
     * Outgoing calls from terminals to Extensions, Services or World
     *
     * @throws \InvalidArgumentException
     */
    public function process()
    {
        /**
         * Determine who is placing this call:
         * - SIPTRANSFER: set by asterisk on blind transfers
         * - Diversion:   set by asterisk on 302 Moved SIP Message
         * - Endpoint:    set by asterisk on matching endpoint
         */
        // Get Refer information
        $transferred = $this->agi->getVariable("SIPTRANSFER");

        // Get Diversion information
        $forwarder = $this->agi->getRedirecting('from-num');

        // Get endpoint from channel Click2Dial variable
        $c2dendpoint = $this->agi->getVariable("C2DENDPOINT");

        /**
         * Blind Transfer from User's terminal
         */
        if (!empty($transferred)) {
            // Asterisk stores the Referred-By header of the transferer
            $transfererHdr = $this->agi->getVariable("SIPREFERREDBYHDR");
            $transfererURI = $this->agi->extractURI($transfererHdr, "uri");
            $transfererNum = $this->agi->extractURI($transfererHdr, "num");
            $transfererDomain = $this->agi->extractURI($transfererHdr, "domain");

            $endpointName = $this->endpointResolver->getEndpointNameFromContact($transfererNum, $transfererDomain);
        } elseif (!empty($forwarder)) {
            /** Redirection from User's terminal - 302 Moved */
            // 302 Moved here caller. The variable MUST store the last dialed endpoint
            $endpointName = $this->agi->getVariable("DIAL_ENDPOINT");
            // Remove any Diversion header generated by Terminals (they will be added if required later)
            $this->agi->setRedirecting('count', 0);
        } elseif (!empty($c2dendpoint)) {
            $endpointName = $c2dendpoint;
        } else {
            /** Normal call from User's terminal  */
            // Get endpoint name from channel
            $endpointName = $this->agi->getEndpoint();
        }

        // Get caller user from endpoint name
        $user = $this->endpointResolver->getUserFromEndpoint($endpointName);
        $this->agi->setVariable("__USERID", $user->getId());

        // Create a new agent for caller user
        $caller = new UserAgent($this->agi, $user);
        $this->channelInfo->setChannelCaller($caller);

        // If this call is being transferred
        if (!empty($transferred) && isset($transfererURI)) {
            // Set Caller extension in Referred header
            $transfererURI = str_replace($endpointName, $user->getExtensionNumber(), $transfererURI);
            $this->agi->setVariable("__SIPREFERREDBYHDR", $transfererURI);
        } elseif (!empty($forwarder)) {
            // Get channel origin
            $origin = $this->channelInfo->getChannelOrigin();
            // Update Diversion Header with User extension (unless its forwarding itself)
            if (!$caller->isEqual($origin)) {
                $this->agi->setRedirecting('from-name,i', $user->getFullName());
                $this->agi->setRedirecting('from-num,i', $user->getExtensionNumber());
                $this->agi->setRedirecting('count,i', 1);
            }
        } else {
            // For now, origin is also the caller user
            $this->channelInfo->setChannelOrigin($caller);
        }

        // Set Company/Brand/Generic Music class
        $company = $caller->getCompany();
        $brand = $company->getBrand();
        $this->agi->setVariable("__COMPANYID", $company->getId());
        $this->agi->setVariable("__COMPANYTYPE", $company->getType());
        $this->agi->setVariable("__BRANDID", $brand->getId());
        $this->agi->setVariable("__ONDEMANDCODE", $company->getOnDemandRecordCode());

        // Mark this call as generated from user
        $this->agi->setVariable("__CALL_TYPE", "internal");

        // Set Outgoing Channels X-CID header variable
        $this->agi->setVariable("__CALL_ID", $this->agi->getCallId());

        // Set user language and music
        $this->agi->setVariable("CHANNEL(language)", $caller->getLanguageCode());
        $this->agi->setVariable("CHANNEL(musicclass)", $company->getMusicClass());

        // Check company On demand record code
        if ($company->getOnDemandRecord()) {
            $this->agi->setVariable("FEATUREMAP(automixmon)", $company->getOnDemandRecordDTMFs());
        }

        // Check User's permission to does this call
        $exten = $this->agi->getExtension();

        // Check if this extension starts with '*' code
        if (strpos($exten, '*') === 0) {
            if ($exten == $this->serviceAction::HELLOCODE) {
                // Handle service code
                $this->serviceAction
                    ->processHello();
                return;
            }

            if (($service = $company->getService($exten))) {
                // Handle service code
                $this->serviceAction
                    ->setService($service)
                    ->process();
            } else {
                // Decline this call if not matching service is found
                $this->agi->error("Invalid Service code %s for company  %s", $exten, $company);
                $this->agi->hangup();
            }

            // Check if this is an extension call
        } elseif (($dstExtension = $company->getExtension($exten))) {
            // Handle extension
            $this->extensionAction
                ->setExtension($dstExtension)
                ->process();

            // Check if this number matches one of friendly trunks patterns
        } elseif (($friend = $company->getFriend($exten))) {
            // Handle call through friendly trunk
            $this->friendCallAction
                ->setFriend($friend)
                ->setDestination($exten)
                ->process();

            // This number don't belong to IvozProvider
        } else {
            if (!$caller->isAllowedToCall($exten)) {
                $this->agi->error("%s is not allowed to call %s", $caller, $exten);
                // Play error notification over progress
                if ($company->hasFeature(Feature::PROGRESS)) {
                    $this->agi->progress("ivozprovider/notAllowed");
                }
                $this->agi->decline();
                return;
            }

            // Otherwise, handle this call as external
            $this->externalNumberCallAction
                ->setDestination($exten)
                ->process();
        }
    }
}
