import { autoSelectOptions } from '@irontec-voip/ivoz-ui/entities/DefaultEntityBehavior';
import { ForeignKeyGetterType } from '@irontec-voip/ivoz-ui/entities/EntityInterface';

import { AdministratorRelPublicEntityPropertyList } from './AdministratorRelPublicEntityProperties';

/** TODO remove this file unless you need to change default behaviour **/
export const foreignKeyGetter: ForeignKeyGetterType = async ({
  cancelToken,
  entityService,
}): Promise<unknown> => {
  const response: AdministratorRelPublicEntityPropertyList<unknown> = {};

  const promises = autoSelectOptions({
    entityService,
    cancelToken,
    response,
    skip: [],
  });

  await Promise.all(promises);

  return response;
};
