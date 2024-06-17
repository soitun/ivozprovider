import { PropertySpec } from '@irontec-voip/ivoz-ui/services/api/ParsedApiSpecInterface';
import {
  EntityValue,
  EntityValues,
} from '@irontec-voip/ivoz-ui/services/entity/EntityService';

export type LocationPropertyList<T> = {
  name?: T;
  description?: T;
  id?: T;
  company?: T;
};

export type LocationProperties = LocationPropertyList<Partial<PropertySpec>>;
export type LocationPropertiesList = Array<
  LocationPropertyList<EntityValue | EntityValues>
>;
