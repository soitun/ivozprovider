import {
  FormControl,
  InputLabel,
  MenuItem,
  Select,
  OutlinedInput,
  FormHelperText
} from '@mui/material';
import { JSXElementConstructor, ReactElement } from 'react';

interface SelectProps {
  className?: string,
  name: string,
  label: string | ReactElement<any, string | JSXElementConstructor<any>>,
  value: any,
  required: boolean,
  disabled: boolean,
  onChange: (event: any) => void,
  hasChanged: boolean,
  choices: any,
  error?: boolean,
  helperText?: string
}

const Dropdown = (props: SelectProps): JSX.Element => {

  const { name, label, value, required, disabled, onChange, choices, error, helperText, hasChanged, className } = props;
  const labelId = `${name}-label`;

  const labelClassName = hasChanged
    ? 'changed'
    : '';

  return (
    <FormControl fullWidth={true} error={error} className={className}>
      <InputLabel required={required} shrink={true} className={labelClassName} id={labelId}>{label}</InputLabel>
      <Select
        value={value}
        disabled={disabled}
        onChange={onChange}
        displayEmpty={true}
        variant="outlined"
        input={
          <OutlinedInput
            name={name}
            type="text"
            label={label}
            notched={true}
          />
        }
      >
        {Object.entries(choices).map(([value, label]: [any, any], key: number) => {
          return (<MenuItem value={value} key={key}>{label}</MenuItem>);
        })}
      </Select>
      {helperText && <FormHelperText>{helperText}</FormHelperText>}
    </FormControl>
  );
};

export default Dropdown;
