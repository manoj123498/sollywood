import React, { useEffect, useState } from 'react';
import { Button, Col, Descriptions, Image, Modal, Row } from 'antd';
import userService from '../../services/user';
import getImage from '../../helpers/getImage';
import { useTranslation } from 'react-i18next';
import Loading from '../../components/loading';
import { shallowEqual, useSelector } from 'react-redux';
import numberToPrice from '../../helpers/numberToPrice';

export default function UserShowModal({ uuid, handleCancel }) {
  const [data, setData] = useState({});
  const [loading, setLoading] = useState(false);
  const { t } = useTranslation();
  const { defaultCurrency } = useSelector(
    (state) => state.currency,
    shallowEqual
  );

  function fetchUser(uuid) {
    setLoading(true);
    userService
      .getById(uuid)
      .then((res) => setData(res.data))
      .finally(() => setLoading(false));
      
  }

  useEffect(() => {
    fetchUser(uuid);
  }, [uuid]);
  console.log("user details",data);
  return (
    <Modal
      visible={!!uuid}
      title={t('user')}
      onCancel={handleCancel}
      footer={[
        <Button type='default' key={'cansel'} onClick={handleCancel}>
          {t('cancel')}
        </Button>,
      ]}
      className={data.shop ? 'large-modal' : ''}
    >
      {!loading ? (
        <Row gutter={24}>
          <Col span={data.shop ? 12 : 24}>
            <Descriptions bordered>
              <Descriptions.Item span={3} label={t('avatar')}>
                <Image
                  src={getImage(data.img)}
                  alt={data.firstname}
                  width={80}
                  className='rounded'
                />
              </Descriptions.Item>
              <Descriptions.Item span={3} label={t('user.id')}>
                {data.id}
              </Descriptions.Item>
              <Descriptions.Item span={3} label={t('name')}>
                {data.firstname} {data.lastname}
              </Descriptions.Item>
              <Descriptions.Item span={3} label={t('gender')}>
                {data.gender}
              </Descriptions.Item>
              <Descriptions.Item span={3} label={t('birthday')}>
                {data.birthday}
              </Descriptions.Item>
              <Descriptions.Item span={3} label={t('email')}>
                {data.email}
              </Descriptions.Item> 
              <Descriptions.Item span={3} label={t('phone')}>
                {data.phone}
              </Descriptions.Item>
              <Descriptions.Item span={3} label={t('role')}>
                {data.role}
              </Descriptions.Item>
              <Descriptions.Item span={3} label={t('My Referral')}>
                {data.my_referral}
              </Descriptions.Item>
              <Descriptions.Item span={3} label={t('Referral From')}>
                {data.referral}
              </Descriptions.Item>
              <Descriptions.Item span={3} label={t('wallet')}>
                {numberToPrice(data.wallet?.price, defaultCurrency.symbol)}
              </Descriptions.Item>
            </Descriptions>
      
          </Col>
          {data.shop ? (
            <Col span={12}>
              <Descriptions bordered>
                <Descriptions.Item span={3} label={t('shop.id')}>
                  {data.shop.id}
                </Descriptions.Item>
                <Descriptions.Item span={3} label={t('shop.name')}>
                  {data.shop.translation?.title}
                </Descriptions.Item>
                <Descriptions.Item span={3} label={t('shop.logo')}>
                  <img
                    src={getImage(data.shop.logo_img)}
                    alt={data.shop.translation?.title}
                    width={100}
                    className='rounded'
                  />
                </Descriptions.Item>
                <Descriptions.Item span={3} label={t('shop.phone')}>
                  {data.shop.phone}
                </Descriptions.Item>
                <Descriptions.Item span={3} label={t('shop.open_close.time')}>
                  {data.shop.open_time} - {data.shop.close_time}
                </Descriptions.Item>
                <Descriptions.Item span={3} label={t('delivery.range')}>
                  {data.shop.delivery_range}
                </Descriptions.Item>
              </Descriptions>
            </Col>
          ) : (
            ''
          )}
        </Row>
      ) : (
        <Loading />
      )}
    </Modal>
  );
}
