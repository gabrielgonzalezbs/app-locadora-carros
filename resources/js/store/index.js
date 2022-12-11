import Vuex from 'vuex';

// import auth from './modules/auth';
// import users from './modules/users';


Vue.use(Vuex);

export default new Vuex.Store({
  actions: {
    async $_setup({ dispatch }) {
      await dispatch('auth/$_setup');
    },
  },

  modules: {
    auth,
    users,
  },
});
