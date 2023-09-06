import { useState, useEffect, useRef } from 'react';
import { useMediaQuery } from "@mui/material";
import { AES, enc } from 'crypto-js';
import { AttendanceSection, CameraSection } from '../../../components/asistencias/MarcarAsistencia';

export const MarcarAsistencia = () => {
  const [horaActual, setHoraActual] = useState(new Date());
  const [mostrarBotonEntrada, setMostrarBotonEntrada] = useState(false);
  const [mostrarBotonSalida, setMostrarBotonSalida] = useState(false);
  const [entradaMarcada, setEntradaMarcada] = useState(false);
  const [salidaMarcada, setSalidaMarcada] = useState(false);
  const [tardanzaMañana, setTardanzaMañana] = useState(false);
  const [tardanzaTarde, setTardanzaTarde] = useState(false);
  const [fotoUsuario, setFotoUsuario] = useState(null);
  const [fotoCapturada, setFotoCapturada] = useState(null);
  const [cameraStream, setCameraStream] = useState(null);
  const [videoEnabled, setVideoEnabled] = useState(false);
  const [capturing, setCapturing] = useState(false);
  const [segundaFotoTomada, setSegundaFotoTomada] = useState(false);
  const [mostrarBotonCamara, setMostrarBotonCamara] = useState(true);
  const isMobile = useMediaQuery("(max-width:768px)");

  useEffect(() => {
    const interval = setInterval(() => {
      setHoraActual(new Date());
    }, 1000);

    const fecha = new Date().toISOString().slice(0, 10);
    const entradaMarcadaLocal = localStorage.getItem(`entrada_${fecha}`);
    const salidaMarcadaLocal = localStorage.getItem(`salida_${fecha}`);
    setEntradaMarcada(entradaMarcadaLocal === 'true');
    setSalidaMarcada(salidaMarcadaLocal === 'true');

    const existeSalidaMarcada = salidaMarcadaLocal === 'true';
    setMostrarBotonCamara(!existeSalidaMarcada);

    const existeEntradaMarcada = entradaMarcadaLocal == 'true';
    setSegundaFotoTomada(existeEntradaMarcada)

    const tokenD = AES.decrypt(
      localStorage.getItem("token"),
      import.meta.env.VITE_TOKEN_KEY
    );
    const token = tokenD.toString(enc.Utf8);
    fetch(import.meta.env.VITE_API_URL + '/attendance/id', {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    })
      .then((response) => response.json())
      .then((data) => {
        const asistenciasHoy = data.attendance.filter((asistencia) => asistencia.date === fecha);
        if (asistenciasHoy.length === 0) {
          setSegundaFotoTomada(false)
        } else {
          setSegundaFotoTomada(true)
        }
      })
      .catch((error) => {
        console.error('Error al obtener las asistencias:', error);
      });

    return () => {
      clearInterval(interval);
    };
  }, []);

  const handleRegistroAsistencia = (tipo) => {
    const fecha = new Date().toISOString().slice(0, 10);

    const formData = new FormData();
    formData.append('date', fecha);
    formData.append(`${tipo}_time`, horaActual.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', second: '2-digit' }));

    const shift = localStorage.getItem('shift');
    const iduser = localStorage.getItem('iduser');
    const photoName = `${shift.charAt(0)}-${iduser}-${tipo === 'admission' ? 'e' : 's'}-${fecha}.jpg`;
    formData.append(`${tipo}_image`, fotoCapturada, photoName);

    const tokenD = AES.decrypt(localStorage.getItem("token"), import.meta.env.VITE_TOKEN_KEY)
    const token = tokenD.toString(enc.Utf8)
    fetch(import.meta.env.VITE_API_URL + '/attendance/create', {
      method: 'POST',
      body: formData,
      headers: {
        Authorization: `Bearer ${token}`,
      },
    })
      .then((response) => response.json())
      .then((data) => {
        console.log(data);
        if (tipo === 'admission') {
          const hora = horaActual.getHours();
          const minutos = horaActual.getMinutes();
          const turno = localStorage.getItem('shift');
          setMostrarBotonEntrada(false)
          setFotoUsuario(null);
          setFotoCapturada(null);
          setMostrarBotonCamara(true);
          setVideoEnabled(false)
          if (
            (turno === 'Mañana' && (hora >= 8 && minutos >= 10) && (hora <= 13))
          ) {
            setTardanzaMañana(true);
          } else {
            setTardanzaMañana(false);
          }

          if (
            (turno === 'Tarde' && (hora >= 14 && minutos >= 10) && (hora <= 19))
          ) {
            setTardanzaTarde(true);
          } else {
            setTardanzaTarde(false);
          }

          localStorage.setItem(`entrada_${fecha}`, 'true');
        } else {
          setMostrarBotonSalida(false)
          setMostrarBotonCamara(false)
          setFotoUsuario(null);
          setFotoCapturada(null);
          setVideoEnabled(false);
          setCameraStream(null);

          localStorage.setItem(`salida_${fecha}`, 'true');
        }
      })
      .catch((error) => {
        console.error('Error al enviar la solicitud:', error);
      });
  };

  const verificarHorario = () => {};

  useEffect(() => {
    verificarHorario();
  }, [horaActual]);

  const reiniciarConteo = () => {
    setCapturing(false);
  };

  const startCamera = () => {
    navigator.mediaDevices
      .getUserMedia({ video: true })
      .then((stream) => {
        setCameraStream(stream);
        videoRef.current.srcObject = stream;
        videoRef.current.style.transform = "scaleX(-1)";
      })
      .catch((error) => {
        console.log('Error accessing camera:', error);
      });
  };

  const stopCamera = () => {
    if (cameraStream && videoRef.current) {
      cameraStream.getTracks().forEach((track) => track.stop());
      videoRef.current.srcObject = null;
      setCameraStream(null);
    }
  };

  const toggleCamera = () => {
    if (videoEnabled) {
      stopCamera();
    } else {
      startCamera();
    }
    setVideoEnabled(!videoEnabled);
    reiniciarConteo();
  };

  const videoRef = useRef(null);

  const handleCapture = () => {
    if (cameraStream) {
      setCapturing(true);
      const videoTrack = cameraStream.getVideoTracks()[0];
      const imageCapture = new ImageCapture(videoTrack);

      imageCapture
        .takePhoto()
        .then((blob) => {
          setFotoUsuario(URL.createObjectURL(blob));
          setCapturing(false);

          if (!segundaFotoTomada) {
            setMostrarBotonEntrada(true);
            setMostrarBotonCamara(false);
            setSegundaFotoTomada(true);
          } else {
            setMostrarBotonSalida(true)
            setMostrarBotonCamara(false)
          }

          stopCamera();
          setVideoEnabled(false);
          setFotoCapturada(blob);
        })
        .catch((error) => {
          console.log('Error taking photo:', error);
          setCapturing(false);
        });
    }
  };

  useEffect(() => {
    if (videoEnabled) {
      startCamera();
      reiniciarConteo();
    }

    return () => {
      stopCamera();
    };
  }, [videoEnabled]);

  const [buttonClickedAdmission, setButtonClickedAdmission] = useState(false);

  const handleButtonClickAdmission = () => {
    setButtonClickedAdmission(true);
    handleRegistroAsistencia('admission');
  };

  const [buttonClicked, setButtonClicked] = useState(false);

  const handleButtonClick = () => {
    setButtonClicked(true);
    handleRegistroAsistencia('departure');
  };

  return (
    <>
      <nav className="flex" >
        <ol className="inline-flex items-center space-x-1 md:space-x-3 uppercase">
          <li className="inline-flex items-center">
            {/* <Link to="/asistencias" className="inline-flex items-center text-base font-medium text-gray-400 hover:text-white">
              <ChecklistIcon />
              <span className='ml-1 text-base font-medium md:ml-2'>Asistencias</span>
            </Link> */}
          </li>
          <li >
            <div className="flex items-center text-gray-500 ">
              {/* <ChevronRightIcon /> */}
              <span className="ml-1 text-base font-medium md:ml-2">Marcar asistencia</span>
            </div>
          </li>
        </ol>
      </nav>
      <div className={`registro-Entrada mt-5 min-h-screen flex ${isMobile ? 'flex-col' : 'justify-center'}`}>
        <CameraSection
          fotoUsuario={fotoUsuario}
          videoEnabled={videoEnabled}
          capturing={capturing}
          handleCapture={handleCapture}
          toggleCamera={toggleCamera}
          cameraStream={cameraStream}
          videoRef={videoRef}
          mostrarBotonCamara={mostrarBotonCamara}
        />

        <AttendanceSection
          horaActual={horaActual}
          mostrarBotonEntrada={mostrarBotonEntrada}
          mostrarBotonSalida={mostrarBotonSalida}
          entradaMarcada={entradaMarcada}
          salidaMarcada={salidaMarcada}
          tardanzaMañana={tardanzaMañana}
          tardanzaTarde={tardanzaTarde}
          buttonClicked={buttonClicked}
          buttonClickedAdmission={buttonClickedAdmission}
          handleButtonClick={handleButtonClick}
          handleButtonClickAdmission={handleButtonClickAdmission}
        />
        {/* <Toaster /> */}
      </div>
    </>
  );
};