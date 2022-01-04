import { CancelToken } from 'axios';
import defaultEntityBehavior, { FetchFksCallback } from 'lib/entities/DefaultEntityBehavior';
import { getI18n } from 'react-i18next';

const LanguageSelectOptions = (callback: FetchFksCallback, cancelToken?: CancelToken): Promise<unknown> => {

    return defaultEntityBehavior.fetchFks(
        '/languages',
        ['id', 'name'],
        (data: any) => {
            const options: any = {};
            const language = getI18n().language.substring(0, 2);
            for (const item of data) {
                options[item.id] = item.name[language];
            }

            callback(options);
        },
        cancelToken
    );
}

export default LanguageSelectOptions;