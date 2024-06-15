import { createSlice, createAsyncThunk } from '@reduxjs/toolkit';
import eventService from '../../services/event';

const initialState = {
  loading: false,
  events: [],
  error: '',
  params: {
    page: 1,
    perPage: 10,
  },
  meta: {},
};

export const fetchEvents = createAsyncThunk('event/fetchEvents', (params = {}) => {
  return eventService
    .getAll({ ...initialState.params, ...params })
    .then((res) => res);
});

const eventSlice = createSlice({
  name: 'event',
  initialState,
  extraReducers: (builder) => {
    builder.addCase(fetchEvents.pending, (state) => {
      state.loading = true;
    });
    builder.addCase(fetchEvents.fulfilled, (state, action) => {
      const { payload } = action;
      state.loading = false;
      state.events = payload.data;
      state.meta = payload.meta;
      state.params.page = payload.meta.current_page;
      state.params.perPage = payload.meta.per_page;
      state.error = '';
    });
    builder.addCase(fetchEvents.rejected, (state, action) => {
      state.loading = false;
      state.events = [];
      state.error = action.error.message;
    });
  },
});

export default eventSlice.reducer;
