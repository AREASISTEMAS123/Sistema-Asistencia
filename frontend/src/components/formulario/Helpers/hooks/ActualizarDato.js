const ActualizarDato = async (
  token,
  palabra,
  url,
  id,
  department_id = "false",
  core_id = "false",
  setIsChecked
) => {
  let dataToSend = [];
  if (department_id == "false" && core_id == "false") {
    dataToSend = {
      name: palabra,
    };
  } else if (core_id == "false") {
    dataToSend = {
      name: palabra,
      department_id,
    };
  } else {
    dataToSend = {
      name: palabra,
      core_id,
    };
  }

  try {
    const response = await fetch(
      import.meta.env.VITE_API_URL + `/${url}/update/${id}`,
      {
        method: "POST",
        headers: {
          Authorization: `Bearer ${token}`,
          "Content-Type": "application/json",
          Accept: "application/json",
        },
        body: JSON.stringify(dataToSend),
      }
    );
    const data = await response.json();
    if (response.ok) {
      console.log("Datos de usuario modificado exitosamente");
      //actualizar data
      setIsChecked((prevIsChecked) => !prevIsChecked);
    } else {
      console.log(`Error al modificar usuario: ${data.error}`);
    }
  } catch (error) {
    console.log(`Error al modificar: ${error}`);
  }
};

export default ActualizarDato;
