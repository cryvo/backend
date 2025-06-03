<?php
// functions/index.js

const functions = require('firebase-functions');
const admin = require('firebase-admin');
const { Configuration, OpenAIApi } = require('openai');

admin.initializeApp();
const openai = new OpenAIApi(new Configuration({
  apiKey: functions.config().openai.key
}));

exports.dailyMarketSummary = functions.pubsub
  .schedule('every day 07:00')
  .timeZone('Asia/Dubai')
  .onRun(async () => {
    // fetch yesterday’s candle data from Firestore or your DB
    const summary = await openai.createChatCompletion({
      model: 'gpt-4o-mini',
      messages: [{ role: 'system', content: 'Generate market summary...' }]
    });
    // send to users via FCM or email
    const payload = {
      notification: {
        title: 'Daily Crypto Summary',
        body: summary.data.choices[0].message.content
      }
    };
    const tokens = await admin.firestore()
      .collection('users')
      .get()
      .then(s => s.docs.map(d => d.data().fcmToken));
    await admin.messaging().sendToDevice(tokens, payload);
  });
