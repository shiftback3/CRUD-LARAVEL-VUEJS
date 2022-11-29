import http from "../http-common";

class DataService {
  getAll(url) {
    return http.get(`/${url}`);
  }

  get(id,url) {
    return http.get(`/${url}/${id}`);
  }

  create(data,url) {
    return http.post(`/${url}`, data);
  }

  update(id, data, url) {
    return http.put(`/${url}/${id}`, data);
  }

  delete(id,url) {
    return http.delete(`/${url}/${id}`);
  }

  deleteAll(url) {
    return http.delete(`/${url}`);
  }

  findByTitle(title, url) {
    return http.get(`/${url}?title=${title}`);
  }
}

export default new DataService();