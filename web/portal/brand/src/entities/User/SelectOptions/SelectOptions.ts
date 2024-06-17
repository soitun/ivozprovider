import { DropdownChoices } from '@irontec-voip/ivoz-ui';
import defaultEntityBehavior from '@irontec-voip/ivoz-ui/entities/DefaultEntityBehavior';
import { SelectOptionsType } from '@irontec-voip/ivoz-ui/entities/EntityInterface';
import store from 'store';

const UserSelectOptions: SelectOptionsType = ({
  callback,
  cancelToken,
}): Promise<unknown> => {
  const entities = store.getState().entities.entities;
  const User = entities.User;

  return defaultEntityBehavior.fetchFks(
    `${User.path}?_order[name]=ASC`,
    ['id', 'name', 'lastname'],
    (data) => {
      const options: DropdownChoices = [];
      for (const item of data) {
        options.push({ id: item.id, label: `${item.name} ${item.lastname}` });
      }

      callback(options);
    },
    cancelToken
  );
};

export default UserSelectOptions;
