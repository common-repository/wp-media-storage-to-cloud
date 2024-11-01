import axios from 'axios'
const rsf_obj = window.w2cloud_obj;

export default() => {
    return axios.create({
        baseURL: rsf_obj.api_url,
        withCredentials: true,
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-WP-Nonce': window.w2cloud_obj.api_nonce,
        }
    })
}
