import { TableCell } from '@mui/material';
import { styled } from '@mui/styles';
import { Link } from "react-router-dom";
import DeleteIcon from '@mui/icons-material/Delete';
import CheckBoxIcon from '@mui/icons-material/CheckBox';
import CheckBoxOutlineBlankIcon from '@mui/icons-material/CheckBoxOutlineBlank';
import { forwardRef } from 'react';

const linkSharedStyles = {
  color: 'inherit',
  cursor: 'pointer',
};

const TableRowLink = forwardRef<any, any>((props, ref) => {
  const { children, className, to, ...rest } = props;
  return (<Link {...rest} to={to} className={className} ref={ref}>{children}</Link>);
});
TableRowLink.displayName = 'TableRowLink';

export const StyledTableRowLink = styled(TableRowLink)(
  () => {
    return {
      ...linkSharedStyles,
      textDecoration: 'none',
    };
  }
);

export const StyledTableRowFkLink = styled(
  (props) => {
    const { children, className, to } = props;
    return (<Link to={to} className={className}>{children}</Link>);
  }
)(
  () => {
    return linkSharedStyles;
  }
);

const _DeleteIcon = forwardRef<any, any>(
  (props, ref) => {
    const { className, onClick, ...rest } = props;
    return (<DeleteIcon {...rest} className={className} onClick={onClick} ref={ref} />);
  }
);
_DeleteIcon.displayName = '_DeleteIcon';

export const StyledDeleteIcon = styled(_DeleteIcon)(
  () => {
    return linkSharedStyles;
  }
);

export const StyledCheckBoxIcon = styled(CheckBoxIcon)(
  () => {
    return {
      color: '#aaa'
    };
  }
);

export const StyledCheckBoxOutlineBlankIcon = styled(CheckBoxOutlineBlankIcon)(
  () => {
    return {
      color: '#aaa'
    };
  }
);

export const StyledTableCell = styled(
  (props) => {
    const { children, className, key } = props;
    return (<TableCell key={key} className={className}>{children}</TableCell>);
  }
)(
  () => {
    return {
      textAlign: 'right'
    };
  }
);
