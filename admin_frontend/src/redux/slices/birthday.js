import { createSlice, createAsyncThunk } from '@reduxjs/toolkit';
import birthdayService from '../../services/birthday';

const initialState = {
  loading: false,
  birthdays: [],
  error: '',
  params: {
    page: 1,
    perPage: 10,
  },
  meta: {},
};

export const fetchBirthday = createAsyncThunk('birthday/fetchBirthday', (params = {}) => {
  return birthdayService
    .getAll({ ...initialState.params, ...params })
    .then((res) => res);
});

const birthdaySlice = createSlice({
  name: 'birthday',
  initialState,
  extraReducers: (builder) => {
    builder.addCase(fetchBirthday.pending, (state) => {
      state.loading = true;
    });
    builder.addCase(fetchBirthday.fulfilled, (state, action) => {
      const { payload } = action;
      state.loading = false;
      state.birthdays = payload.data;
      state.meta = payload.meta;
      state.params.page = payload.meta.current_page;
      state.params.perPage = payload.meta.per_page;
      state.error = '';
    });
    builder.addCase(fetchBirthday.rejected, (state, action) => {
      state.loading = false;
      state.birthdays = [];
      state.error = action.error.message;
    });
  },
});

export default birthdaySlice.reducer;