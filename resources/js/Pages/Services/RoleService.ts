import axios from 'axios';

class RoleService {
    private apiUrl: string;
    private headers: { [key: string]: string };

    constructor() {
        this.apiUrl = '/api/role';
        this.headers = {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${localStorage.getItem('access_token')}`,
            'Cache-Control': 'no-cache'
        };
    }

    async getRoles() {
        const response = await axios.get(this.apiUrl, { headers: this.headers });
        return response.data;
    }

    async updateRole(roleId, roleData) {
        const response = await axios.put(`${this.apiUrl}/${roleId}`, roleData, { headers: this.headers });
        return response.data;
    }

    async deleteRole(id) {
        const response = await axios.delete(`${this.apiUrl}/${id}`, { headers: this.headers });
        return response;
    }
    async updateRoleProtocols(roleId: string, protocols: string[]): Promise<any> {
        const response = await axios.put(`${this.apiUrl}/${roleId}/protocols`, {protocols}, {headers: this.headers});
        return response.data;
    }
}

export default new RoleService();
