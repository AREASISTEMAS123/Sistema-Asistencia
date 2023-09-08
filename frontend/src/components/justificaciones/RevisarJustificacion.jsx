import { useState } from 'react'
import { useEffect } from 'react'
import { Link, useParams } from 'react-router-dom'
import moment from 'moment'
import BalanceIcon from '@mui/icons-material/Balance'
import ChevronRightIcon from '@mui/icons-material/ChevronRight'
import { FechData } from './helpers/FechData'

export const RevisarJustificacion = () => {
    const { id } = useParams()
    const [faltasList, setFaltasList] = useState([])

    const rol = localStorage.getItem('rol')

    const hasRole = (targetRole) => {
        return rol === targetRole
    }

    useEffect(() => {
        FechData()
            .then((e) => setFaltasList(e))
            .catch((e) => console.log(e))
    }, [id])

    const isRechazadoOrAceptado = (prop) => {
        if (prop.status === 2) {
            return 'Rechazado'
        } else if (prop.status === 3) {
            return 'En proceso'
        } else {
            return 'Aceptado'
        }
    }

    return (
        <div className='w-[70%] m-auto'>
            <div className='w-full flex flex-col md:flex-row items-center text-white relative'>
                <nav className='flex'>
                    <ol className='inline-flex items-center space-x-1 md:space-x-3 uppercase'>
                        <li className='inline-flex items-center'>
                            <Link
                                to='/añadir-justificacion'
                                className='inline-flex items-center text-base font-medium text-gray-400 hover:text-white'>
                                <BalanceIcon />
                                <span className='ml-1 text-base font-medium md:ml-2'>
                                    Justificaciones
                                </span>
                            </Link>
                        </li>
                        <li>
                            <div className='flex items-center text-gray-500 '>
                                <ChevronRightIcon />
                                <span className='ml-1 text-base font-medium md:ml-2'>
                                    Detalle justificacion
                                </span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>
            <div className='rounded-lg mt-2'>
                {faltasList
                    .filter((item) => {
                        const idConvertido = Number(id)
                        if (item.id === idConvertido) {
                            return true
                        } else {
                            return false
                        }
                    })
                    .map((item) => (
                        <div key={item.id} className='mb-6'>
                            <div className='flex flex-col md:flex-row gap-2'>
                                <div className='bg-cv-primary text-white flex flex-col p-4 rounded-lg md:w-3/5 border border-gray-500'>
                                    <h2 className='text-lg font-semibold text-center'>
                                        JUSTIFICACIÓN Nº {item.id}
                                    </h2>
                                    <div className='mt-6 bg-cv-primary text-white rounded'>
                                        <div className='w-full flex flex-col md:flex-row md:space-x-12 items-center '>
                                            <div className='w-full md:w-auto flex-1'>
                                                <div className='text-sm font-medium'>
                                                    <label className='text-slate-400 text-base'>
                                                        Tipo:
                                                    </label>
                                                    <p className='capitalize text-lg'>{`${
                                                        item.type === 0
                                                            ? 'Falta'
                                                            : 'Tardanza'
                                                    }`}</p>
                                                </div>
                                            </div>
                                            <div className='w-full md:w-auto flex-1'>
                                                <div className='text-sm font-medium'>
                                                    <label className='text-slate-400 text-base'>
                                                        Fecha:
                                                    </label>
                                                    <p className='text-lg'>
                                                        {moment(
                                                            item.justification_date
                                                        ).format('DD/MM/YYYY')}
                                                    </p>
                                                </div>
                                            </div>
                                            {hasRole('Lider Nucleo') && (
                                                <div className='w-full md:w-auto flex-1'>
                                                    <div className='text-sm font-medium'>
                                                        <label className='font-medium text-slate-400 text-base'>
                                                            Estado:
                                                        </label>
                                                        <p className='capitalize text-lg'>
                                                            {isRechazadoOrAceptado(
                                                                item
                                                            )}
                                                        </p>
                                                    </div>
                                                </div>
                                            )}
                                        </div>
                                        <div className='mt-4 text-sm font-medium'>
                                            <label className='text-slate-400 text-base'>
                                                Motivo:
                                            </label>
                                            <p>{item.reason}</p>
                                        </div>
                                    </div>
                                </div>

                                {hasRole('Colaborador') ? (
                                    <div className='bg-cv-primary text-white flex flex-col p-4 rounded-lg md:w-2/5 border border-gray-500'>
                                        <h2 className='text-lg uppercase font-semibold text-center'>
                                            Información
                                        </h2>
                                        <div className='mt-6 space-y-4 bg-cv-primary text-white rounded'>
                                            <div className='w-full md:w-auto'>
                                                <div className='text-sm font-medium'>
                                                    <label className='font-medium text-slate-400 text-base'>
                                                        Estado:
                                                    </label>
                                                    <p className='capitalize text-lg'>
                                                        {isRechazadoOrAceptado(
                                                            item
                                                        )}
                                                    </p>
                                                </div>
                                            </div>
                                            {isRechazadoOrAceptado(item) ===
                                                'Rechazado' && (
                                                <div className='w-full md:w-auto'>
                                                    <label className='font-medium text-slate-400 text-base'>
                                                        Motivo:
                                                    </label>
                                                    <p className='text-left mt-2'>
                                                        {item.reason_decline}
                                                    </p>
                                                </div>
                                            )}
                                        </div>
                                    </div>
                                ) : (
                                    <div className='bg-cv-primary text-white flex flex-col p-4 rounded-lg md:w-2/5 border border-gray-500'>
                                        <h2 className='text-lg uppercase font-semibold text-center'>
                                            Datos Usuario
                                        </h2>
                                        <div className='mt-6 space-y-4 bg-cv-primary text-white rounded'>
                                            <div className='w-full md:w-auto'>
                                                <div className='text-sm font-medium'>
                                                    <label className='font-medium text-slate-400 text-base'>
                                                        Nombre:
                                                    </label>
                                                    <p className='capitalize text-lg'>
                                                        {'Moises'}
                                                    </p>
                                                </div>
                                            </div>
                                            <div className='w-full flex flex-col md:flex-row md:space-x-12 items-center '>
                                                <div className='w-full md:w-auto flex-1'>
                                                    <div className='text-sm font-medium'>
                                                        <label className='text-slate-400 text-base'>
                                                            DNI:
                                                        </label>
                                                        <p className='capitalize text-lg'>
                                                            {'1345678'}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div className='w-full md:w-auto flex-1'>
                                                    <div className='text-sm font-medium'>
                                                        <label className='text-slate-400 text-base'>
                                                            Teléfono:
                                                        </label>
                                                        <p className='capitalize text-lg'>
                                                            {'9877232778'}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                )}
                            </div>
                            <div className='bg-cv-primary mt-3 rounded-xl p-4 border border-gray-500'>
                                <div className='font-semibold text-center text-white mb-8'>
                                    <p className='uppercase text-lg'>
                                        Evidencia
                                    </p>
                                </div>
                                <div className='flex items-center justify-center'>
                                    {item.evidence.endsWith('.jpg') ||
                                    item.evidence.endsWith('.png') ||
                                    item.evidence.endsWith('.jpeg') ? (
                                        <img
                                            src={
                                                import.meta.env
                                                    .VITE_BACKEND_SERVER_URL +
                                                `/${item.evidence}`
                                            }
                                            alt='Image'
                                        />
                                    ) : item.evidence.endsWith('.pdf') ? (
                                        <embed
                                            src={
                                                import.meta.env
                                                    .VITE_BACKEND_SERVER_URL +
                                                `/${item.evidence}`
                                            }
                                            type='application/pdf'
                                            width='100%'
                                            height='600px'
                                        />
                                    ) : (
                                        <div>Unsupported file format</div>
                                    )}
                                </div>
                            </div>
                        </div>
                    ))}
            </div>
        </div>
    )
}