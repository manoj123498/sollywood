import request from './request';

const eventService = {
  getAll: () => request.get('dashboard/admin/event', {}),
  create: (data) => request.post('dashboard/admin/event', data),
  update: (id, params) => request.put(`dashboard/admin/event/${id}`, {}, { params }),
  delete: (id) => request.delete(`dashboard/admin/event/${id}`),
};

export default eventService;
