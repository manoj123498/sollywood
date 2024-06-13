import React, { useState, useEffect } from 'react';
import { toast } from 'react-toastify';
import { Card } from 'antd';
import moment from 'moment';
import { Calendar, momentLocalizer } from 'react-big-calendar';
import 'react-big-calendar/lib/css/react-big-calendar.css';
import TextArea from 'antd/lib/input/TextArea';
import { useTranslation } from 'react-i18next';
import eventService from '../../services/event';
import { fetchEvents } from 'redux/slices/event';

const localizer = momentLocalizer(moment);

export default function Index() {
    const { t } = useTranslation();
    const [events, setEvents] = useState([]);
    const [showModal, setShowModal] = useState(false);
    const [selectedDate, setSelectedDate] = useState(null);
    const [eventTitle, setEventTitle] = useState('');
    const [eventDescription, setEventDescription] = useState('');
    const [eventCashbackAmount, setEventCashbackAmount] = useState('');
    const [selectEvent, setSelectEvent] = useState(null);

    useEffect(() => {
        eventService
            .getAll()
            .then(({ data }) => {
                const dispEvents = data.map(event => ({
                    //id: event.id,
                    title: event.title,
                    description: event.description,
                    cashback_amount: event.cashback_amount,
                    start: event.event_start_date,
                    end: event.event_end_date,
                }));
                //console.log(dispEvents);
                setEvents(dispEvents);
                setSelectEvent(dispEvents);
            }).catch(error => {
                toast.error(t('Error fetching events'));
            });
    }, []);

    const fetchEvents = () => {
        eventService
            .getAll()
            .then(({ data }) => {
                const dispEvents = data.map(event => ({
                    //id: event.id,
                    title: event.title,
                    description: event.description,
                    cashback_amount: event.cashback_amount,
                    start: event.event_start_date,
                    end: event.event_end_date,
                }));
                //console.log(dispEvents);
                setEvents(dispEvents);
                setSelectEvent(dispEvents);
            }).catch(error => {
                toast.error(t('Error fetching events'));
            });
    };

    const handleSelectSlot = (slotInfo) => {
        setShowModal(true);
        setSelectedDate(slotInfo.start);
        setSelectEvent(null);
    }

    const handleSelectEvent = (event) => {
        setShowModal(true);
        setSelectEvent(event);
        setEventTitle(event.title);
        setEventDescription(event.description);
        setEventCashbackAmount(event.cashback_amount);
    }

    const resetForm = () => {
        setShowModal(false);
        setEventTitle('');
        setEventDescription('');
        setEventCashbackAmount('');
        setSelectEvent(null);
    }

    const saveEvent = () => {
        if (eventTitle || selectedDate) {
            if (selectEvent) {
                const updateEvent = { ...selectEvent, title: eventTitle, description: eventDescription, cashback_amount: eventCashbackAmount };
                const updateEvents = events.map((event) => 
                    event === selectEvent ? updateEvent : event
                );
                console.log("select id: ",selectEvent);
                eventService
                    .update(selectEvent.id, updateEvent)
                    .then(() => {
                        setEvents(updateEvents);
                        toast.success(t('successfully.updated'));
                        fetchEvents();
                    })
                    .finally(() => {
                        setShowModal(false);
                        resetForm();
                    });
            } else {
                const newEvent = {
                    title: eventTitle,
                    description: eventDescription,
                    cashback_amount: eventCashbackAmount,
                    start: selectedDate,
                    end: moment(selectedDate).add(1, 'hour').toDate(),
                };
                eventService
                    .create(newEvent)
                    .then(() => {
                        setEvents([...events, newEvent]);
                        toast.success(t('successfully.created'));
                        fetchEvents();
                    })
                    .finally(() => { resetForm(); });
            }
        }
    };

    const deleteEvents = () => {
        if (selectEvent) {
            const updateEvents = events.filter((event) => event !== selectEvent);
            eventService
                .delete(selectEvent.id)
                .then(() => {
                    toast.success(t('successfully.deleted'));
                    setEvents(updateEvents);
                })
                .finally(() => { resetForm(); });
        }
    }

    return (
        <Card title={t('Event Settings')}>
            <div>
                <Calendar
                    localizer={localizer}
                    events={events}
                    views={["month","week","day"]}
                    //toolbar={false}
                    startAccessor="start"
                    endAccessor="end"
                    style={{ height: 500 }}
                    selectable={true}
                    onSelectSlot={handleSelectSlot}
                    onSelectEvent={handleSelectEvent}
                />

                {showModal && (
                    <div className="modal" style={{ display: 'block', backgroundColor: 'rgba(0.0.0.0.5)', position: 'fixed', top: 0, bottom: 0, left: 0, right: 0 }}>
                        <div className="modal-dialog">
                            <div className="modal-content">
                                <div className="modal-header">
                                    <h5 className="modal-title">{selectEvent ? 'Edit Event' : 'Add Event'}</h5>
                                    <button type="button" className="btn-close"
                                        onClick={() => {
                                            setShowModal(false);
                                            resetForm();
                                        }}
                                    ></button>
                                </div>
                                <div className="modal-body">
                                    <div>
                                        <label>Event Title: </label>
                                        <input
                                            type='text'
                                            className='form-control'
                                            id='eventTitle'
                                            value={eventTitle}
                                            onChange={(e) => setEventTitle(e.target.value)}
                                            required
                                        />
                                    </div>
                                    <br/>
                                    <div>
                                        <label>Event Description: </label>
                                        <TextArea
                                            type='text'
                                            className='form-control'
                                            id='eventDescription'
                                            value={eventDescription}
                                            onChange={(e) => setEventDescription(e.target.value)}
                                            required
                                        />
                                    </div>
                                    <br/>
                                    <div>
                                        <label>Cashback Amount: </label>
                                        <input
                                            type='number'
                                            className='form-control'
                                            id='eventCashbackAmount'
                                            value={eventCashbackAmount}
                                            min={1}
                                            onChange={(e) => setEventCashbackAmount(e.target.value)}
                                            required
                                        />
                                    </div>
                                </div>
                                <div className="modal-footer">
                                    {selectEvent && (
                                        <button
                                            type='button'
                                            className='btn btn-danger me-2'
                                            onClick={deleteEvents}
                                        >Delete</button>
                                    )}
                                    <button type="button" onClick={saveEvent} className="btn btn-primary">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                )}
            </div>
        </Card>
    );
}
