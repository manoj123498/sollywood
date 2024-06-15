import request from './request';

const birthdayService = {
  getAll: (params) =>
    request.get('dashboard/admin/birthday', { params }),
  getById: (params) =>
    request.get(`dashboard/admin/birthday/1`, { params }),
  update: (id, params) =>
    request.put(`dashboard/admin/birthday/${id}`, {}, { params }),
};

export default birthdayService;
