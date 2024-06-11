import React, { useState, useEffect } from 'react';
import { Button, Card, Col, Form, Input, Row, Select, Spin, Switch } from 'antd';
import { toast } from 'react-toastify';
import { useNavigate, useParams } from 'react-router-dom';
import { shallowEqual, useDispatch, useSelector } from 'react-redux';
import { disableRefetch, removeFromMenu, setMenuData } from '../../redux/slices/menu';
import eventService from '../../services/event';
import { useTranslation } from 'react-i18next';

import Calendar from 'react-calendar';

export default function Events() {
    const [value, onChange] = useState(new Date());
    return (
        <>
            <h1> hii </h1>
            <Calendar 
                onChange={onChange} 
                value={value} 
            />
        </>
    );
}
  

