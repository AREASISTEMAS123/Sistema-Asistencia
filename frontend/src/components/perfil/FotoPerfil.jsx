import React from "react";

export const FotoPerfil = ({colaborador}) => {

  return (
    <div className="col-span-1 md:col-span-2 row-span-5 md:col-start-4 bg-cv-primary rounded-2xl p-5 order-1 md:order-2">
      <div className="w-full h-full flex items-center justify-center">
        <img
          // src="https://github.com/midudev.png"
          src={colaborador.avatar}
          alt=""
          className="w-60 h-60 flex items-center justify-center rounded-full ring ring-cv-cyan object-cover bg-cv-primary"
        />
      </div>
    </div>
  );
};
