const db = require('../config/firebase');
const axios = require('axios');

function listenToOrderChanges() {
    db.collection('orders').onSnapshot((snapshot) => {
        snapshot.docChanges().forEach(async (change) => {
            const data = change.doc.data();
            const id = change.doc.id;

            const payload = {
                id: id,
                status: data.status,
                customerId: data.customerId,
                riderId: data.riderId || null,
                pickUpLocation: data.pickUpLocation || null,
                dropOffLocation: data.dropOffLocation || null,
                updatedAt: data.updatedAt
            };

            try {
                const response = await axios.post('http://127.0.0.1:8000/api/firestore/order-sync', payload, {
                    headers: {
                        'Authorization': `Bearer YOUR_SANCTUM_TOKEN`,
                        'Accept': 'application/json'
                    }
                });
                console.log('✅ Order Synced:', response.data);
            }
            catch (error) {
                console.error('❌ Failed to sync order:', error.response?.data || error.message);
            }

            if (change.type === 'added') {
                console.log(`🟢 New Order [${id}]:`, data);
            }
            else if (change.type === 'modified') {
                console.log(`🟡 Updated Order [${id}]:`, data);
            }
            else if (change.type === 'removed') {
                console.log(`🔴 Removed Order [${id}]:`, data);
            }
        });
    });
}

module.exports = listenToOrderChanges;