import { DropdownChoices } from '@irontec-voip/ivoz-ui';
import defaultEntityBehavior from '@irontec-voip/ivoz-ui/entities/DefaultEntityBehavior';
import { SelectOptionsType } from '@irontec-voip/ivoz-ui/entities/EntityInterface';
import store from 'store';

const BrandServiceSelectOptions: SelectOptionsType = ({
  callback,
  cancelToken,
}): Promise<unknown> => {
  const entities = store.getState().entities.entities;
  const BrandService = entities.BrandService;

  return defaultEntityBehavior.fetchFks(
    `${BrandService.path}?_order[name]=ASC`,
    ['id', 'name'],
    (data) => {
      const options: DropdownChoices = [];
      for (const item of data) {
        options.push({ id: item.id, label: item.name });
      }

      callback(options);
    },
    cancelToken
  );
};

export default BrandServiceSelectOptions;
