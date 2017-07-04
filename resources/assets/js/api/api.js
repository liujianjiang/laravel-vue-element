import axios from 'axios';

let base = 'dashboard';

export const AuthCheck = params => { return axios.post(`/${base}/auth/check`); };
export const requestLogin = params => { return axios.post(`${base}/auth/login`, params).then(res => res.data); };

/*article*/
export const getArticle = params => { return axios.get(`/${base}/article`, { params: params }); }
export const ArticleStore = params => { return axios.post(`/${base}/article`, { params: params}); };
export const ArticleDestroy = params => { return axios.delete(`/${base}/article/destroy`, { params: params }); };
export const ArticleEdit = params => { return axios.get(`/${base}/article/edit`, { params: params }); };
export const ArticleUpdate = params => { return axios.put(`/${base}/article/category`, { params: params }); };
export const ArticleSearch = params => { return axios.get(`/${base}/article/search`, { params: params }); };
/*category*/
export const getAllCategories = params => {return axios.get(`/${base}/getAllCategories`)};
export const getCategoriesListPage = params => { return axios.get(`/${base}/category`, { params: params }); };
export const CategoryStore = params => { return axios.post(`/${base}/category`, { params: params }); };
export const CategoryDestroy = params => { return axios.delete(`/${base}/category/destroy`, { params: params }); };
export const updateCategory = params => { return axios.put(`/${base}/category/update`, { params: params }); };

/*tag*/
export const getTags = params => { return axios.get(`/${base}/tag`, { params: params }); };
export const TagStore = params => { return axios.post(`/${base}/tag`, { params: params }); };
export const TagUpdate = params => { return axios.put(`${base}/tag/update`, { params: params })};
export const TagDelete = params => { return axios.delete(`${base}/tag/destroy`, { params: params })};


/*article*/




