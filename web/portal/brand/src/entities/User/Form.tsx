import useFkChoices from '@irontec-voip/ivoz-ui/entities/data/useFkChoices';
import {
  EntityFormProps,
  FieldsetGroups,
} from '@irontec-voip/ivoz-ui/entities/DefaultEntityBehavior';
import { Form as DefaultEntityForm } from '@irontec-voip/ivoz-ui/entities/DefaultEntityBehavior/Form';
import _ from '@irontec-voip/ivoz-ui/services/translations/translate';

import { foreignKeyGetter } from './ForeignKeyGetter';

const Form = (props: EntityFormProps): JSX.Element => {
  const { entityService, row, match } = props;
  const fkChoices = useFkChoices({
    foreignKeyGetter,
    entityService,
    row,
    match,
  });

  const groups: Array<FieldsetGroups | false> = [
    {
      legend: _('Main'),
      fields: [
        'name',
        'lastname',
        'email',
        'pass',
        'doNotDisturb',
        'isBoss',
        'active',
        'maxCalls',
        'externalIpCalls',
        'rejectCallMethod',
        'multiContact',
        'gsQRCode',
        'id',
        'company',
        'bossAssistant',
        'transformationRuleSet',
        'language',
        'terminal',
        'timezone',
        'outgoingDdi',
        'oldPass',
      ],
    },
  ];

  return <DefaultEntityForm {...props} fkChoices={fkChoices} groups={groups} />;
};

export default Form;
