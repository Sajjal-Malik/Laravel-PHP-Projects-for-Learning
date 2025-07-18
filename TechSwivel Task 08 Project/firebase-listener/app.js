require('dotenv').config();

const listenToOrderChanges = require('./listeners/orderListener');

console.log('🔥 Listening to Firestore "orders"...');

listenToOrderChanges();