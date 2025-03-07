pipeline {

    agent any

    // ------------------------------------------------------------------------
    // Pipeline options
    // ------------------------------------------------------------------------
    options {
        timeout(time: 25, unit: 'MINUTES')
        timestamps()
        disableConcurrentBuilds()
        buildDiscarder(
            logRotator(
                artifactDaysToKeepStr: '10',
                artifactNumToKeepStr: '10',
                daysToKeepStr: '10',
                numToKeepStr: '10'
            )
        )
    }

    // ------------------------------------------------------------------------
    // Environment configuration
    // ------------------------------------------------------------------------
    environment {
        SYMFONY_PHPUNIT_DIR = "/opt/phpunit/"
        SYMFONY_PHPUNIT_VERSION = "6.5.14"
    }

    stages {
        // --------------------------------------------------------------------
        // Prepare stage
        // --------------------------------------------------------------------
        stage('Prepare') {
            when {
                anyOf {
                    expression { env.CHANGE_ID && pullRequest.labels.contains('ci-no-tests') == false }
                    branch "bleeding"
                    branch "artemis"
                }
            }
            agent {
                docker {
                    image 'ironartemis/ivozprovider-testing-base'
                    args '--user jenkins --volume ${WORKSPACE}:/opt/irontec/ivozprovider'
                    reuseNode true
                }
            }
            steps {
                sh '/opt/irontec/ivozprovider/tests/docker/bin/prepare-and-run'
                sh '/opt/irontec/ivozprovider/web/rest/platform/bin/generate-keys --test'
            }
        }

        // --------------------------------------------------------------------
        // Testing stage
        // --------------------------------------------------------------------
        stage('Testing') {
            when {
                anyOf {
                    expression { env.CHANGE_ID && pullRequest.labels.contains('ci-no-tests') == false }
                    branch "bleeding"
                    branch "artemis"
                }
            }
            parallel {
                stage ('app-console') {
                    agent {
                        docker {
                            image 'ironartemis/ivozprovider-testing-base'
                            args '--user jenkins --volume ${WORKSPACE}:/opt/irontec/ivozprovider'
                            reuseNode true
                        }
                    }
                    steps {
                        sh '/opt/irontec/ivozprovider/library/bin/test-app-console'
                    }
                    post {
                        success { notifySuccessGithub() }
                        failure { notifyFailureGithub() }
                        always  { notifyJira() }
                    }
                }
                stage ('phpstan') {
                    agent {
                        docker {
                            image 'ironartemis/ivozprovider-testing-phpstan'
                            args '--volume ${WORKSPACE}:/opt/irontec/ivozprovider/ --entrypoint ""'
                        }
                    }
                    steps {
                        sh '/opt/irontec/ivozprovider/tests/docker/bin/prepare-and-run'
                        sh '/opt/irontec/ivozprovider/library/bin/test-phpstan'
                    }
                    post {
                        success { notifySuccessGithub() }
                        failure { notifyFailureGithub() }
                        always  {
                            cleanWs()
                            notifyJira()
                        }
                    }
                }
                stage ('codestyle') {
                    agent {
                        docker {
                            image 'ironartemis/ivozprovider-testing-base'
                            args '--user jenkins --volume ${WORKSPACE}:/opt/irontec/ivozprovider'
                            reuseNode true
                        }
                    }
                    steps {
                        sh '/opt/irontec/ivozprovider/library/bin/test-codestyle --branch'
                        sh '/opt/irontec/ivozprovider/library/bin/php-cs-fixer'
                    }
                    post {
                        success { notifySuccessGithub() }
                        failure { notifyFailureGithub() }
                        always  { jiraSendBuildInfo() }
                    }
                }
                stage ('i18n') {
                    agent {
                        docker {
                            image 'ironartemis/ivozprovider-testing-base'
                            args '--user jenkins --volume ${WORKSPACE}:/opt/irontec/ivozprovider'
                            reuseNode true
                        }
                    }
                    steps {
                        sh '/opt/irontec/ivozprovider/library/bin/test-i18n'
                    }
                    post {
                        success { notifySuccessGithub() }
                        failure { notifyFailureGithub() }
                        always  { notifyJira() }
                    }
                }
                stage ('phpspec') {
                    agent {
                        docker {
                            image 'ironartemis/ivozprovider-testing-base'
                            args '--user jenkins --volume ${WORKSPACE}:/opt/irontec/ivozprovider'
                            reuseNode true
                        }
                    }
                    steps {
                        sh '/opt/irontec/ivozprovider/library/bin/test-phpspec'
                    }
                    post {
                        success { notifySuccessGithub() }
                        failure { notifyFailureGithub() }
                        always  { notifyJira() }
                    }
                }
                stage ('api-platform') {
                    agent {
                        docker {
                            image 'ironartemis/ivozprovider-testing-base'
                            args '--user jenkins --volume ${WORKSPACE}:/opt/irontec/ivozprovider'
                            reuseNode true
                        }
                    }
                    steps {
                        sh '/opt/irontec/ivozprovider/web/rest/platform/bin/test-api-spec'
                        sh '/opt/irontec/ivozprovider/web/rest/platform/bin/test-api --skip-db'
                    }
                    post {
                        success { notifySuccessGithub() }
                        failure { notifyFailureGithub() }
                        always  { notifyJira() }
                    }
                }
                stage ('api-brand') {
                    agent {
                        docker {
                            image 'ironartemis/ivozprovider-testing-base'
                            args '--user jenkins --volume ${WORKSPACE}:/opt/irontec/ivozprovider'
                            reuseNode true
                        }
                    }
                    steps {
                        sh '/opt/irontec/ivozprovider/web/rest/brand/bin/test-api-spec'
                        sh '/opt/irontec/ivozprovider/web/rest/brand/bin/test-api --skip-db'
                    }
                    post {
                        success { notifySuccessGithub() }
                        failure { notifyFailureGithub() }
                        always  { notifyJira() }
                    }
                }
                stage ('api-client') {
                    agent {
                        docker {
                            image 'ironartemis/ivozprovider-testing-base'
                            args '--user jenkins --volume ${WORKSPACE}:/opt/irontec/ivozprovider'
                            reuseNode true
                        }
                    }
                    steps {
                        sh '/opt/irontec/ivozprovider/web/rest/client/bin/test-api-spec'
                        sh '/opt/irontec/ivozprovider/web/rest/client/bin/test-api --skip-db'
                    }
                    post {
                        success { notifySuccessGithub() }
                        failure { notifyFailureGithub() }
                        always  { notifyJira() }
                    }
                }
                stage ('orm') {
                    agent {
                        docker {
                            image 'ironartemis/ivozprovider-testing-base'
                            args '--user jenkins --volume ${WORKSPACE}:/opt/irontec/ivozprovider'
                            reuseNode true
                        }
                    }
                    steps {
                        sh '/opt/irontec/ivozprovider/schema/bin/test-orm --skip-db'
                    }
                    post {
                        success { notifySuccessGithub() }
                        failure { notifyFailureGithub() }
                        always  { notifyJira() }
                    }
                }
                stage ('generators') {
                    agent {
                        docker {
                            image 'ironartemis/ivozprovider-testing-base'
                            args '--user jenkins --volume ${WORKSPACE}:/opt/irontec/ivozprovider'
                        }
                    }
                    steps {
                        sh '/opt/irontec/ivozprovider/tests/docker/bin/prepare-and-run'
                        sh '/opt/irontec/ivozprovider/schema/bin/test-generators'
                    }
                    post {
                        success { notifySuccessGithub() }
                        failure { notifyFailureGithub() }
                        always {
                            cleanWs()
                            notifyJira()
                        }
                    }
                }
                stage ('schema') {
                    steps {
                        script {
                            docker.image('mysql:5.7').withRun('-e "MYSQL_ROOT_PASSWORD=changeme"') { c ->
                                docker.image('mysql:5.7').inside("--link ${c.id}:data.ivozprovider.local") {
                                    /* Wait until mysql service is up */
                                    sh 'while ! mysqladmin ping -hdata.ivozprovider.local --silent; do sleep 1; done'
                                }
                                docker.image('ironartemis/ivozprovider-testing-base')
                                      .inside("--volume ${WORKSPACE}:/opt/irontec/ivozprovider --link ${c.id}:data.ivozprovider.local") {
                                    sh '/opt/irontec/ivozprovider/schema/bin/test-schema'
                                    sh '/opt/irontec/ivozprovider/schema/bin/test-duplicate-keys'
                                }
                            }
                        }
                    }
                    post {
                        success { notifySuccessGithub() }
                        failure { notifyFailureGithub() }
                        always  { notifyJira() }
                    }
                }
            }
        }
    }

    // ------------------------------------------------------------------------
    // Pipeline post-actions
    // ------------------------------------------------------------------------
    post {
        failure { notifyFailureMattermost() }
        fixed { notifyFixedMattermost() }
        cleanup { cleanWs()}
    }
}

// -----------------------------------------------------------------------------
// Helper Functions
// -----------------------------------------------------------------------------

void notifySuccessGithub() {
    githubNotify([
        context: "ivozprovider-testing-${STAGE_NAME}",
        description: "Finished",
        status: "SUCCESS"
    ])
}

void notifyFailureGithub() {
    githubNotify([
        context: "ivozprovider-testing-${STAGE_NAME}",
        description: "Finished",
        status: "FAILURE"
    ])
}

void notifyFailureMattermost() {
    if (env.GIT_BRANCH == 'artemis' || env.GIT_BRANCH == 'bleeding') {
        mattermostSend([
            channel: "#ivozprovider",
            color: "#FF0000",
            message: ":red_circle: Branch ${env.GIT_BRANCH} tests failed :red_circle: - (<${env.BUILD_URL}|Open>)"
        ])
    }
}

void notifyFixedMattermost() {
    if (env.GIT_BRANCH == 'artemis' || env.GIT_BRANCH == 'bleeding') {
        mattermostSend([
            channel: "#ivozprovider",
            color: "#008000",
            message: ":thumbsup_all: Branch ${env.GIT_BRANCH} tests fixed :thumbsup_all: - (<${env.BUILD_URL}|Open>)"
        ])
    }
}

void notifyJira() {
    jiraSendBuildInfo site: 'ironvoip.atlassian.net', branch: "${env.CHANGE_BRANCH}"
}
