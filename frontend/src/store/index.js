import { createStore } from 'vuex';
import axiosClient from '../axios';

const store = createStore({
	state: {
		activeUser: {},
		currentArticle: {},
		articles: [],
		users: [],
	},
	getters: {
		getActiveUser(state) {
			return state.activeUser;
		},
		getActiveUserId(state) {
			return state.activeUser.id;
		},
		getCurrentArticle(state) {
			return state.currentArticle;
		},
		getArticles(state) {
			return state.articles;
		},
		getUsers(state) {
			return state.users;
		},
	},
	actions: {
		createArticle({ commit }, article) {
			return axiosClient.post('/articles', article).then(({ data }) => {
				commit('addArticle', data.article);
				commit('setArticle', data.article);
				return data;
			});
		},
		deleteArticle({ commit }, article) {
			let headers = {
				can_edit: 'false',
			};
			if (article.user.can_edit) {
				headers['can_edit'] = 'true';
			}
            
			console.log(headers);
			return axiosClient.delete(`/articles/${article.id}`, { headers: headers }).then(({ data }) => {
				commit('deleteArticle', data.article.id);
				return data;
			});
		},
		updateArticle({ commit }, article) {
			console.log(article);
			return axiosClient.put(`/articles/${article.id}`, article).then(({ data }) => {
				commit('replaceArticle', data.article);
				return data;
			});
		},
		fetchArticle({ commit }, articleId) {
			return axiosClient.get(`/articles/${articleId}`).then(({ data: article }) => {
				commit('setArticle', article);
				return article;
			});
		},
		fetchAllArticles({ commit }) {
			return axiosClient.get('/articles').then(({ data }) => {
				// reverse to make the newest articles be stored first in the array.
				const reversedArticles = data.articles.slice().reverse();
				commit('setArticles', reversedArticles);
				return reversedArticles;
			});
		},
		createUser({ commit }, user) {
			return axiosClient.post('/users', user).then(({ data }) => {
				commit('addUser', data.user);
				commit('setUser', data.user);
				return data;
			});
		},
		deleteUser({ commit }, userId) {
			// no user delete functionality yet
		},
		fetchUser({ commit }, userId) {
			return axiosClient.get(`/users/${userId}`).then(({ data }) => {
				commit('setUser', data.user);
				return data.user;
			});
		},
		fetchAllUsers({ commit }) {
			return axiosClient.get('/users').then(({ data }) => {
				commit('setUsers', data.users);
				return data.users;
			});
		},
	},
	mutations: {
		setUser: (state, user) => {
			state.activeUser.data = user;
		},
		addUser: (state, user) => {
			state.users.push(user);
		},
		addArticle: (state, article) => {
			state.articles.unshift(article);
		},
		deleteArticle: (state, articleId) => {
			const articleToDeleteIndex = state.articles.findIndex((article) => article.id === articleId);

			if (articleToDeleteIndex > -1) {
				state.articles.splice(articleToDeleteIndex, 1);
			}
		},
		replaceArticle: (state, article) => {
			const articleToUpdateIndex = state.articles.findIndex((art) => art.id === article.id);
			state.articles.splice(articleToUpdateIndex, 1, article);
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
