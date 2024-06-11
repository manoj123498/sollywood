import request from './request';

const eventService = {
  getAll: (params) =>
    request.get('dashboard/admin/event', { params }),
//   getById: (params) =>
//     request.get(`dashboard/admin/birthday/1`, { params }),
//   update: (id, params) =>
//     request.put(`dashboard/admin/birthday/${id}`, {}, { params }),
};

export default eventService;
