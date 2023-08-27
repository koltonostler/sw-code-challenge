import { createStore } from 'vuex';
import axiosClient from '../axios';

const store = createStore({
	state: {
		activeUser: {
			data: {},
		},
		currentArticle: {},
		articles: [],
		users: [],
	},
	getters: {},
	actions: {
		createArticle({ commit }, article, userId) {
			return axiosClient.post('/articles', { article, userId }).then(({ data: article }) => {
				commit('addArticle', article);
				commit('setArticle', article);
				return article;
			});
		},
		deleteArticle({ commit }, articleId) {
			return axiosClient.delete(`/articles/${articleId}`).then((res) => {
				commit('deleteArticle', articleId);
				return res;
			});
		},
		updateArticle({ commit }, article) {
			return axiosClient.put(`/articles/${article.id}`, article).then(({ data: article }) => {
				commit('replaceArticle', article);
				return article;
			});
		},
		fetchArticle({ commit }, articleId) {
			return axiosClient.get(`/articles/${articleId}`).then(({ data: article }) => {
				commit('setArticle', article);
				return article;
			});
		},
		fetchAllArticles({ commit }) {
			return axiosClient.get('/articles').then(({ data: articles }) => {
				commit('setArticles', articles);
				return article;
			});
		},
		createUser({ commit }, user) {
			return axiosClient.post('/users', user).then(({ data: user }) => {
				commit('setUser', user);
				commit('setToken', data.token);
				return user;
			});
		},
		deleteUser({ commit }, userId) {
			return axiosClient.delete(`/users/${userId}`).then((res) => {
				commit('logout');
				return res;
			});
		},
		fetchUser({ commit }, userId) {
			return axiosClient.get(`/users/${userId}`).then(({ data: user }) => {
				commit('setUser', user);
				commit('setToken', data.token);
				return user;
			});
		},
		fetchAllUsers({ commit }) {
			return axiosClient.get('/users').then(({ data: users }) => {
				commit('setUsers', users);
				return users;
			});
		},
		logout({ commit }) {
			return axiosClient.post('/logout').then((res) => {
				commit('logout');
				return res;
			});
		},
	},
	mutations: {
		logout: (state) => {
			state.activeUser.data = {};
			state.activeUser.token = null;
			localStorage.removeItem('Access_Token');
		},
		setUser: (state, userData) => {
			state.activeUser.data = userData.user;
		},
		setToken: (state, token) => {
			state.activeUser.token = token;
			localStorage.setItem('Access_Token', token);
		},
		addArticle: (state, article) => {
			state.articles.push(article);
		},
		deleteArticle: (state, articleId) => {
			const articleToDeleteIndex = state.articles.findIndex((article) => article.id === articleId);

			if (articleToDeleteIndex > -1) {
				state.articles.splice(articleToDeleteIndex, 1);
			}
		},
		replaceArticle: (state, article) => {
			const articleToUpdateIndex = state.articles.findIndex((art) => art.id === article.id);

			if (articleToUpdateIndex > -1) {
				state.articles.splice(articleToUpdateIndex, 1, article);
			}
		},
		setArticle: (state, article) => {
			state.currentArticle = article;
		},
		setArticles: (state, articles) => {
			state.articles = articles;
		},
		setUsers: (state, users) => {
			state.users = users;
		},
	},
	modules: {},
});

export default store;
