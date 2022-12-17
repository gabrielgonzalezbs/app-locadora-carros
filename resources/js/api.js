import axios from 'axios';

const baseURL = 'http://127.0.0.1:8000/api/v1/';

const api = axios.create({ baseURL });

const { cookie } = document

const token = /token=(?<meuGrupo>.*?);/gm.exec(cookie)

api.defaults.headers.authorization = token ? `Bearer ${token[1]}` : null;

api.defaults.headers.accept = 'application/json';

api.interceptors.response.use(
    response => {
        return response;
    },
    error => {
        if (error.response.status == 401 && error.response.data.message == "Token has expired") {
            api.post('refresh')
                .then( response => {
                    document.cookie = `token=${response.data.token}`
                    window.location.reload()
                })
        }
    }
)

function setupApiOnResponseError(responseInterceptor) {
  api.interceptors.response.use(null, responseInterceptor);
}

export { api, setupApiOnResponseError }
