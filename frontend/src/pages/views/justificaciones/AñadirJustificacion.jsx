import { useState, useEffect } from 'react'

import {
    ItemJustificaciones,
    ModalAgregar,
    ModalAlert,
} from '../../../components/justificaciones'
import { Alert, Box, Modal, Pagination, Snackbar } from '@mui/material'
import { FechData } from '../../../components/justificaciones/helpers/FechData'

export const AñadirJustificacion = () => {
    const [page, setPage] = useState(1)
    // const [currentPage, setCurrentPage] = useState(1)
    const [countPage, setCountPage] = useState(null)
    const [cards, setCards] = useState([])
    // estas dos estados es para manejar las modales
    const [modal, setModal] = useState(false)
    const [modalAlert, setModalAlert] = useState(false)
    const [modalAgregar, setModalAgregar] = useState(false)

    const [buscador_tipoJustificacion, setbuscador_tipoJustificacion] =
        useState('')
    const [buscadorStatus, setBuscadorStatus] = useState('')
    // const [buscadorFechaInicio, setBuscadorFechaInicio] = useState('')
    const [buscadorFecha, setBuscadorFecha] = useState('')

    // Para Toas Alert Success
    const [toasSuccess, setToasSuccess] = useState(false)
    const handleClose = (event, reason) => {
        if (reason === 'clickaway') {
            return
        }
        setToasSuccess(false)
    }

    const onShowTerminos = () => {
        setModal(true)
        setModalAlert(true)
    }

    const handleBuscar = (page) => {
        FechData({ page })
            .then((e) => {
                setCards(e.data)
                setCountPage(e.total)
            })
            .catch((e) => setCards(e))
    }

    const limpiar = () => {
        setbuscador_tipoJustificacion('')
        setBuscadorStatus('')
        setBuscadorFecha('')
        setPage(1)
    }

    useEffect(() => {
        handleBuscar(page)
    }, [page])

    return (
        <>
            <Snackbar
                anchorOrigin={{ vertical: 'top', horizontal: 'center' }}
                open={toasSuccess}
                autoHideDuration={6000}
                onClose={handleClose}>
                <Alert
                    onClose={handleClose}
                    severity='success'
                    sx={{ width: '100%' }}>
                    Fue exitoso su envío de justificación!
                </Alert>
            </Snackbar>
            <Modal
                open={modal}
                onClose={() => {
                    setModal(!modalAlert)
                }}
                aria-labelledby='modal-modal-title'
                aria-describedby='modal-modal-description'>
                <Box>
                    {modalAlert && (
                        <ModalAlert mostrarModalAgregar={setModalAgregar} />
                    )}
                    {modalAgregar && (
                        <ModalAgregar
                            cancelarModalAlert={setModal}
                            setToasSuccess={setToasSuccess}
                            handleBuscar={handleBuscar}
                        />
                    )}
                </Box>
            </Modal>

            <div className='min-h-screen px-8'>
                <p className='ml-1 text-base font-medium md:ml-2 uppercase text-gray-400 hover:text-white'>
                    justificacion
                </p>
                <div className='space-y-5'>
                    {/* <div className='flex flex-wrap justify-center'>
                        <button
                            type='button'
                            className='w-full md:w-1/3 text-center bg-cv-cyan rounded-lg py-3 px-6 text-cv-primary font-semibold uppercase whitespace-nowrap active:scale-95 ease-in-out duration-300 '
                            onClick={onShowTerminos}>
                            AGREGAR JUSTIFICACIÓN
                        </button>
                    </div> */}

                    <div className='w-full flex flex-col md:flex-row items-center justify-between gap-5'>
                        {/* Buscador por tipo de justificación: falta o tardanza */}
                        <div className='w-full text-gray-400'>
                            <select
                                className='px-3 py-1 rounded-md outline-none bg-cv-secondary border border-black w-full'
                                value={buscador_tipoJustificacion}
                                onChange={(e) =>
                                    setbuscador_tipoJustificacion(
                                        e.target.value
                                    )
                                }>
                                <option value=''>Tipo de justificación</option>
                                <option value='0'>Falta</option>
                                <option value='1'>Tardanza</option>
                            </select>
                        </div>
                        {/* Buscador por tipo de status: en proceso, aceptado o rechazado */}
                        <div className='w-full text-gray-400'>
                            <select
                                className='px-3 py-1 rounded-md outline-none bg-cv-secondary border border-black w-full'
                                value={buscadorStatus}
                                onChange={(e) =>
                                    setBuscadorStatus(e.target.value)
                                }>
                                <option value=''>Estado</option>
                                <option value='1'>Aceptado</option>
                                <option value='2'>Rechazado</option>
                                <option value='3'>En proceso</option>
                            </select>
                        </div>
                        {/* <div className='w-full text-white'>
                            <input
                                className='px-3 py-1 rounded-md outline-none bg-cv-secondary border border-black w-full'
                                type='date'
                                id='fecha'
                                value={buscadorFechaInicio}
                                onChange={(e) =>
                                    setBuscadorFechaInicio(e.target.value)
                                }
                            />
                        </div> */}
                        {/* adecuar */}
                        <div className='w-full text-gray-400'>
                            <input
                                className='px-3 py-1 rounded-md outline-none bg-cv-secondary border border-black w-full'
                                type='date'
                                id='fecha'
                                value={buscadorFecha}
                                onChange={(e) =>
                                    setBuscadorFecha(e.target.value)
                                }
                            />
                        </div>
                        <div className=''>
                            <button
                                className='w-full text-black outline-none px-4 py-2 font-semibold text-center bg-cv-cyan rounded-md active:scale-95 ease-in-out duration-300 uppercase'
                                onClick={limpiar}>
                                Limpiar
                            </button>
                        </div>
                        <div className=''>
                            <button
                                className='w-full text-black outline-none px-4 py-2 font-semibold text-center bg-cv-cyan rounded-md active:scale-95 ease-in-out duration-300 uppercase'
                                onClick={onShowTerminos}>
                                Agregar
                            </button>
                        </div>
                    </div>

                    <ItemJustificaciones
                        cards={cards}
                        page={page}
                        buscador_tipoJustificacion={buscador_tipoJustificacion}
                        buscadorStatus={buscadorStatus}
                        buscadorFecha={buscadorFecha}
                    />

                    <Pagination
                        className='flex justify-center'
                        count={Math.ceil(countPage / 6)}
                        page={page}
                        onChange={(event, value) => {
                            setPage(value)
                            handleBuscar(value)
                        }}
                        sx={{
                            '& .MuiPaginationItem-root': {
                                color: '#57F3FF', // Cambia '#colorDeseado' por el color que quieras.
                            },
                        }}
                    />
                </div>
            </div>
        </>
    )
}
