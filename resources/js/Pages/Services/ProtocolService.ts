import axios from 'axios';

class ProtocolService {
    private apiUrl: string;
    private headers: { [key: string]: string };

    constructor() {
        this.apiUrl = '/api/protocol';
        this.headers = {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${localStorage.getItem('access_token')}`,
            'Cache-Control': 'no-cache'
        };
    }

    async fetchProtocols(): Promise<any> {
        const response = await axios.get(this.apiUrl, {headers: this.headers});
        return response.data;
    }
    async deleteProtocol(id) {
        const response = await axios.delete(`${this.apiUrl}/${id}`, { headers: this.headers });
        return response;
    }
    async updateProtocol(protocolId, protocolData) {
        const response = await axios.put(`${this.apiUrl}/${protocolId}`, protocolData, { headers: this.headers });
        return response.data;
    }
    async createProtocol(protocolData) {
        const response = await axios.post(this.apiUrl, protocolData, { headers: this.headers });
        return response.data;
    }
}

export default new ProtocolService();
