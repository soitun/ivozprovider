import { EntityValues, isEntityItem } from '@irontec-voip/ivoz-ui';
import EditRowButton from '@irontec-voip/ivoz-ui/components/List/Content/CTA/EditRowButton';
import defaultEntityBehavior, {
  ChildDecorator as DefaultChildDecorator,
} from '@irontec-voip/ivoz-ui/entities/DefaultEntityBehavior';
import EntityInterface, {
  ChildDecoratorType,
} from '@irontec-voip/ivoz-ui/entities/EntityInterface';
import _ from '@irontec-voip/ivoz-ui/services/translations/translate';
import TransformIcon from '@mui/icons-material/Transform';

import {
  TransformationRuleSetProperties,
  TransformationRuleSetPropertyList,
} from './TransformationRuleSetProperties';

const properties: TransformationRuleSetProperties = {
  description: {
    label: _('Description'),
    maxLength: 250,
  },
  internationalCode: {
    label: _('International Code'),
    pattern: new RegExp(`^[0-9]{2,10}$`),
    maxLength: 5,
    default: '00',
    helpText: _(`Code used for internationals calls, usually 00.`),
  },
  trunkPrefix: {
    label: _('Trunk Prefix'),
    pattern: new RegExp(`^[0-9]+$`),
    maxLength: 5,
    helpText: _(`Prefix used for national out of area calls.`),
  },
  areaCode: {
    label: _('Area code'),
    maxLength: 10,
    helpText: _('Calling a number within the same Area can omit Area Code'),
  },
  nationalLen: {
    label: _('National number length'),
    default: 9,
    helpText: _(
      `How long are the normal phone numbers called inside this country?`
    ),
  },
  generateRules: {
    label: _('Generate Transformation Rules automatically'),
    helpText: _('Mark this option to regenerate all rules after saving.'),
  },
  name: {
    label: _('Name'),
    maxLength: 100,
    multilang: true,
  },
  country: {
    label: _('Country code'),
    default: 70,
  },
};

export const ChildDecorator: ChildDecoratorType = (props) => {
  const { routeMapItem, row } = props;

  if (
    isEntityItem(routeMapItem) &&
    routeMapItem.entity.iden === TransformationRuleSet.iden
  ) {
    const allowEdit = row.editable === true;
    if (!allowEdit) {
      return <EditRowButton disabled={true} row={row} path={''} />;
    }
  }

  return DefaultChildDecorator(props);
};

const TransformationRuleSet: EntityInterface = {
  ...defaultEntityBehavior,
  icon: TransformIcon,
  link: '/doc/en/administration_portal/brand/settings/numeric_transformations.html',
  iden: 'TransformationRuleSet',
  title: _('Numeric transformation', { count: 2 }),
  path: '/transformation_rule_sets',
  toStr: (row: TransformationRuleSetPropertyList<EntityValues>) =>
    `${row?.name?.en}`,
  defaultOrderBy: '',
  properties,
  columns: ['name', 'description'],
  acl: {
    ...defaultEntityBehavior.acl,
    iden: 'TransformationRuleSets',
  },
  ChildDecorator,
  selectOptions: async () => {
    const module = await import('./SelectOptions');

    return module.default;
  },
  foreignKeyResolver: async () => {
    const module = await import('./ForeignKeyResolver');

    return module.default;
  },
  foreignKeyGetter: async () => {
    const module = await import('./ForeignKeyGetter');

    return module.foreignKeyGetter;
  },
  Form: async () => {
    const module = await import('./Form');

    return module.default;
  },
};

export default TransformationRuleSet;
