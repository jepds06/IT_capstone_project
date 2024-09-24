import { _required } from "#tailwind-config/theme/aria";

const validationMessage = {
    required: "This field is required."
  }
export const adminFields = [
    {
      name: "adminFirstName",
      type: "text",
      label: "First Name",
      placeholder: "Enter your first name",
      attributes: "required",
    },
    {
      name: "adminLastName",
      type: "text",
      label: "Last Name",
      placeholder: "Enter your last name",
    },
    {
      name: "contactNum",
      type: "tel",
      label: "Contact Number",
      placeholder: "Ex: 09xxxxxxxxx",
      attributes: 'required pattern="[0-9]{11}" maxlength="11"',
    },
    {
      name: "adminAddress",
      type: "text",
      label: "Address",
      placeholder: "Enter your address",
    },
    {
      name: "username",
      type: "text",
      label: "Username",
      placeholder: "Enter your username",
    },
    {
      name: "email",
      type: "email",
      label: "Email",
      placeholder: "Enter your email",
    },
    {
      name: "password",
      label: "Password",
      type: "password",
      placeholder: "Enter your password",
      attributes: 'required pattern="(?=.*[a-zA-Z])(?=.*[0-9])[A-Za-z0-9]{8,}"',
      helpText: "Password must be alphanumeric between 8-32 character length",
    },
  ];
 
  export const validateAdministrator = (state: any) => {
    const errors = [];

    if (!state.adminFirstName)
        errors.push({ path: "adminFirstName", message: validationMessage.required });
    if (!state.adminLastName)
        errors.push({ path: "adminLastName", message: validationMessage.required });
    if (!state.contactNum)
        errors.push({ path: "contactNum", message: validationMessage.required });
    if (!/^\d{11}$/.test(state.contactNum))
        errors.push({path: "contactNum",message: "Contact number must be 11 digits" });
    if (!state.adminAddress)
        errors.push({ path: "adminAddress", message: validationMessage.required });
    if (!state.email)
      errors.push({ path: "email", message: validationMessage.required });
    if (!state.password)
      errors.push({ path: "password", message: validationMessage.required });
    if (!/^(?=.*[a-zA-Z])(?=.*[0-9])[A-Za-z0-9]{8,}$/.test(state.password))
      errors.push({path: "password", message: "Password must be alphanumeric between 8-32 character length",});
    if (!state.username)
      errors.push({ path: "username", message: validationMessage.required });

    return errors;
  };
  
  export const customerFields = [
    {
      name: "cstrFirstName",
      type: "text",
      label: "First Name",
      placeholder: "Enter your first name",
      attributes: "required",
    },
    {
      name: "cstrLastName",
      type: "text",
      label: "Last Name",
      placeholder: "Enter your last name",
    },
    {
      name: "contactNum",
      type: "tel",
      label: "Contact Number",
      placeholder: "Ex: 09xxxxxxxxx",
      attributes: 'required pattern="[0-9]{11}" maxlength="11"',
    },
    {
      name: "cstrAddress",
      type: "text",
      label: "Address",
      placeholder: "Enter your address",
    },
    {
      name: "customerType",
      type: "select",
      label: "Customer Type",
      placeholder: "Enter your customer type",
      options: [
        "Industry",
        "Individual",
      ],
    },
    {
      name: "prefContactMethod",
      type: "select",
      label: "Preffered Contact Method",
      placeholder: "Enter your Preferred Contact Method",
      options: [
       "Email",
       "Contact Number",
      ],
    },
    {
      name: "username",
      type: "text",
      label: "Username",
      placeholder: "Enter your username",
    },
    {
      name: "email",
      type: "email",
      label: "Email",
      placeholder: "Enter your email",
    },
    {
      name: "password",
      label: "Password",
      type: "password",
      placeholder: "Enter your password",
      attributes: 'required pattern="(?=.*[a-zA-Z])(?=.*[0-9])[A-Za-z0-9]{8,}"',
      helpText: "Password must be alphanumeric between 8-32 character length",
    },
  ];

  export const validateCustomer = (state: any) => {
    const errors = [];
    if (!state.cstrFirstName)
        errors.push({ path: "cstrFirstName", message: validationMessage.required });
    if (!state.cstrLastName)
        errors.push({ path: "cstrLastName", message: validationMessage.required });
    if (!state.contactNum)
        errors.push({ path: "contactNum", message: validationMessage.required });
    if (!/^\d{11}$/.test(state.contactNum))
        errors.push({
        path: "contactNum",
        message: "Contact number must be 11 digits", 
        });
    if (!state.cstrAddress)
        errors.push({ path: "cstrAddress", message: validationMessage.required });
    if (!state.customerType)
        errors.push({ path: "customerType", message: validationMessage.required });
    if (!state.prefContactMethod)
        errors.push({ path: "prefContactMethod", message: validationMessage.required });
    if (!state.username)
        errors.push({ path: "username", message: validationMessage.required });
    if (!state.email)
      errors.push({ path: "email", message: validationMessage.required });
    if (!state.password)
      errors.push({ path: "password", message: validationMessage.required });
    if (!/^(?=.*[a-zA-Z])(?=.*[0-9])[A-Za-z0-9]{8,}$/.test(state.password))
      errors.push({
        path: "password",
        message: "Password must be alphanumeric between 8-32 character length",
      });

    return errors;
  };
  
  export const supplierFields = [
    {
      name: "supplierName",
      type: "text",
      label: "Name",
      placeholder: "Enter your name",
      attributes: "required",
    },
    {
      name: "supplierContactNum",
      type: "tel",
      label: "Contact Number",
      placeholder: "Ex: 09xxxxxxxxx",
      attributes: 'required pattern="[0-9]{11}" maxlength="11"',
    },
    {
      name: "supplierContactPerson",
      type: "text",
      label: "Contact Person",
      placeholder: "Enter your contact person",
    },
    {
      name: "supplierAddress",
      type: "text",
      label: "Address",
      placeholder: "Enter your address",
    },
    {
      name: "supplierType",
      type: "select",
      label: "Supplier Type",
      placeholder: "Enter your supplier type",
      options: [
         "Industry", 
        "Individual",  
      ],
    },
    {
      name: "username",
      type: "text",
      label: "Username",
      placeholder: "Enter your username",
    },
    {
      name: "email",
      type: "email",
      label: "Email",
      placeholder: "Enter your email",
    },
    {
      name: "password",
      label: "Password",
      type: "password",
      placeholder: "Enter your password",
      attributes: 'required pattern="(?=.*[a-zA-Z])(?=.*[0-9])[A-Za-z0-9]{8,}"',
      helpText: "Password must be alphanumeric between 8-32 character length",
    },
  ];

  export const validateSupplier = (state: any) => {
    const errors = [];
    if (!state.supplierName)
        errors.push({ path: "supplierName", message:  validationMessage.required });
    if (!state.supplierContactNum)
        errors.push({ path: "supplierContactNum", message:  validationMessage.required });
    if (!/^\d{11}$/.test(state.supplierContactNum))
        errors.push({
          path: "supplierContactNum",
          message: "Contact number must be 11 digits",
        });
    if (!state.supplierAddress)
        errors.push({ path: "supplierAddress", message:  validationMessage.required });
    if (!state.supplierType)
        errors.push({ path: "supplierType", message:  validationMessage.required });
    if (!state.username)
        errors.push({ path: "username", message:  validationMessage.required });
    if (!state.email)
      errors.push({ path: "email", message:  validationMessage.required });
    if (!state.supplierContactPerson)
      errors.push({ path: "supplierContactPerson", message:  validationMessage.required });
    if (!state.password)
      errors.push({ path: "password", message: validationMessage.required });
    if (!/^(?=.*[a-zA-Z])(?=.*[0-9])[A-Za-z0-9]{8,}$/.test(state.password))
      errors.push({
        path: "password",
        message: "Password must be alphanumeric between 8-32 character length",
      });
    return errors;
  };
  
  