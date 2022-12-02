import axios from 'axios';

const baseURL = 'http://127.0.0.1:8000/api/v1/';

const api = axios.create({ baseURL });

const { cookie } = document

const token = /token=(?<meuGrupo>.*?);/gm.exec(cookie)

api.defaults.headers.authorization = token ? `Bearer ${token[1]}` : null;

function setupApiOnResponseError(responseInterceptor) {
  api.interceptors.response.use(null, responseInterceptor);
}

export { api, setupApiOnResponseError }
