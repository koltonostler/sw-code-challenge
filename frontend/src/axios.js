import axios from 'axios';
import store from './store';

// get apiURL from .env file
const apiURL = import.meta.env.VITE_APP_API_ENDPOINT;

const axiosClient = axios.create({
	baseURL: apiURL,
});

axiosClient.interceptors.request.use((config) => {
	config.headers.Authorization = `Bearer ${store.state.activeUser.token}`;
	return config;
});

export default axiosClient;
