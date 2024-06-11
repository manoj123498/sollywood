import React, { useState, useEffect } from 'react';
import { Button, Card, Col, Form, Input, Row, Select, Spin, Switch } from 'antd';
import { toast } from 'react-toastify';
import { useNavigate, useParams } from 'react-router-dom';
import { shallowEqual, useDispatch, useSelector } from 'react-redux';
import { disableRefetch, removeFromMenu, setMenuData } from '../../redux/slices/menu';
import birthdayService from '../../services/birthday';
import { useTranslation } from 'react-i18next';

export default function BirthdayEdit() {
  const { t } = useTranslation();
  const { activeMenu } = useSelector((state) => state.menu, shallowEqual);
  const { id } = useParams();
  const dispatch = useDispatch();
  const [form] = Form.useForm();
  const navigate = useNavigate();
  const [loading, setLoading] = useState(false);
  const [loadingBtn, setLoadingBtn] = useState(false);
  const [giftAmount, setGiftAmount] = useState('');

  const { defaultLang, languages } = useSelector(
    (state) => state.formLang,
    shallowEqual
  );

  useEffect(() => {
    return () => {
      const data = form.getFieldsValue(true);
      dispatch(setMenuData({ activeMenu, data }));
    };
  }, []);

  const fetchBirthday = (id) => {
    setLoading(true);
    birthdayService
      .getById(id)
      .then(({ data }) => {
        const translations = getLanguageFields(data);
        form.setFieldsValue({ ...data, ...translations });
      })
      .finally(() => {
        setLoading(false);
        dispatch(disableRefetch(activeMenu));
      });
  };

  function getLanguageFields(data) {
    if (!data) {
      return {};
    }
   
    const translations = data;
    setGiftAmount(translations.gift_amount);

    const result = languages.map((item) => ({
      [`gift_amount[${item.locale}]`]: translations.gift_amount ? translations.gift_amount[item.locale] : undefined,
    }));
    return Object.assign({}, ...result);
  }

  const onFinish = (values) => {
    const body = { ...values };
    setLoadingBtn(true);
    const nextUrl = 'settings/birthday';
    birthdayService
      .update(1, body)
      .then(() => {
        toast.success(t('successfully.updated'));
        dispatch(removeFromMenu({ ...activeMenu, nextUrl }));
        navigate(`/${nextUrl}`);
        dispatch(fetchBirthday());
      })
      .finally(() => setLoadingBtn(false));
  };

  useEffect(() => {
    if (activeMenu.refetch) {
      fetchBirthday(id);
    }
  }, [activeMenu.refetch]);

  return (
    <Card title={t('Edit Gift Settings')}>
      {!loading ? (
        <Form
          name='basic'
          layout='vertical'
          onFinish={onFinish}
          form={form}
          initialValues={{ ...activeMenu.data }}
        >
          <Row gutter={12}>
            <Col span={12}>
              {languages.map((item) => (
                <Form.Item
                  key={'gift_amount' + item.locale}
                  label={t('Gift Settings')}
                  name={`gift_amount`}
                  rules={[
                    {
                      required: item.locale === defaultLang,
                      message: t('required'),
                    },
                  ]} >
                  <Input type='text' defaultValue={giftAmount} />
                </Form.Item>
              ))}
            </Col>
          </Row>
          <Button type='primary' htmlType='submit' loading={loadingBtn}>
            {t('submit')}
          </Button>
        </Form>
      ) : (
        <div className='d-flex justify-content-center align-items-center'>
          <Spin size='large' className='py-5' />
        </div>
      )}
    </Card>
  );
}