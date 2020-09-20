export const state = () => ({
  me: null,
  token: '',
  posts: [],
  post:{},
});

const url = 'http://localhost:8000/api'

export const mutations = {
  setMe(state, payload) {
    state.me = payload;
  },
  setToken(state, payload) {
    state.token = payload;
  },
  addMainPost(state, payload) {
    state.posts.unshift(payload);
  },
  editPost(state, payload) {
    state.post.title = payload.post.title;
    state.post.content = payload.post.content;
  },
  removePost(state, payload) {
    const index = state.posts.findIndex(v => v.id === payload.post_id);
    state.posts.splice(index, 1);
  },
  loadPosts(state, payload) {
    state.posts = payload.posts;
  },
  loadPost(state, payload) {
    state.post = payload.post;
  },
  editTitle (state, title) {
    state.post.title = title;
  },
  editContent (state, content) {
    state.post.content = content;
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



  add({ commit, state }, payload) {
    this.$axios.post(`${url}/post`,{
      title:payload.title,
      content:payload.content,
    }, {
      withCredentials: false,
      headers: {
        Authorization:`Bearer ${state.token}`
      }
    })
      .then((res) => {
        commit('addMainPost', res.data);
      })
      .catch((err) => {
        console.error(err);
      });
  },
  edit({ commit, state }, payload) {
    this.$axios.patch(`${url}/post/${payload.id}`,{
      title:payload.title,
      content:payload.content,
    }, {
      withCredentials: false,
      headers: {
        Authorization:`Bearer ${state.token}`
      }
    })
      .then((res) => {
        commit('editPost', res.data);
      })
      .catch((err) => {
        console.error(err);
      });
  },
  remove({ commit, state }, payload) {
    this.$axios.delete(`${url}/post/${payload.id}`, {
      withCredentials: false,
      headers: {
        Authorization:`Bearer ${state.token}`
      }
    })
      .then((res) => {
        commit('removePost', res.data);
      })
      .catch((err) => {
        console.error(err);
      });
  },
  loadPosts({ commit }) {
    this.$axios.get(`${url}/posts`, {
      withCredentials: false,
    })
      .then((res) => {
        commit('loadPosts', res.data);
      })
      .catch((err) => {
        console.error(err);
      });
  },
  loadPost({ commit }, payload) {
    this.$axios.get(`${url}/post/${payload.id}`, {
      withCredentials: false,
    })
      .then((res) => {
        commit('loadPost', res.data);
      })
      .catch((err) => {
        console.error(err);
      });
  }
};
