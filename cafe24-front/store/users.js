export const state = () => ({
  me: null,
  token: '',
});

const url = 'http://localhost:8000/api'

export const mutations = {
  setMe(state, payload) {
    state.me = payload;
  },
  setToken(state, payload) {
    state.token = payload;
  }
};

export const actions = {
  signUp({ commit, state }, payload) {
    this.$axios.post(`${url}/register`, {
      email: payload.email,
      name: payload.name,
      password: payload.password,
      password_confirmation: payload.password_confirmation,
    }, {
      withCredentials: false,
    })
      .then((res) => {
        commit('setMe', res.data);
      })
      .catch((err) => {
        console.error(err);
      });
  },
  logIn({ commit }, payload) {
    this.$axios.post(`${url}/login`, {
      email: payload.email,
      password: payload.password,
    }, {
      withCredentials: false,
    })
      .then((res) => {
        commit('setMe', res.data.me);
        commit('setToken', res.data.token);
      })
      .catch((err) => {
        console.error(err);
      });
  },
  logOut({ commit,state }) {
    this.$axios.post(`${url}/logout`, {}, {
      withCredentials: false,
      headers: {
        Authorization:`Bearer ${state.token}`
      }
    })
      .then(() => {
        commit('setMe', null);
      })
      .catch((err) => {
        console.error(err);
      });
  },
};
