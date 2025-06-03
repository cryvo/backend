// File: mobile-app/screens/ChatbotScreen.js

import React, { useState, useRef, useEffect } from 'react'
import {
  View,
  Text,
  TextInput,
  TouchableOpacity,
  FlatList,
  KeyboardAvoidingView,
  Platform,
  StyleSheet
} from 'react-native'
import api from '../utils/api'
import { PaperPlane } from 'lucide-react-native'

export default function ChatbotScreen() {
  const [messages, setMessages] = useState([])
  const [input, setInput] = useState('')
  const flatListRef = useRef(null)

  // scroll to bottom when messages update
  useEffect(() => {
    flatListRef.current?.scrollToEnd({ animated: true })
  }, [messages])

  const sendMessage = async () => {
    if (!input.trim()) return
    const userMsg = { from: 'user', text: input.trim() }
    setMessages(prev => [...prev, userMsg])
    setInput('')
    try {
      const res = await api.post('/chat', { message: userMsg.text })
      const botMsg = { from: 'bot', text: res.reply }
      setMessages(prev => [...prev, botMsg])
    } catch {
      setMessages(prev => [
        ...prev,
        { from: 'bot', text: 'Sorry, an error occurred.' }
      ])
    }
  }

  const renderItem = ({ item }) => (
    <View
      style={[
        styles.bubble,
        item.from === 'user' ? styles.userBubble : styles.botBubble
      ]}
    >
      <Text style={item.from === 'user' ? styles.userText : styles.botText}>
        {item.text}
      </Text>
    </View>
  )

  return (
    <KeyboardAvoidingView
      style={styles.container}
      behavior={Platform.OS === 'ios' ? 'padding' : undefined}
      keyboardVerticalOffset={Platform.OS === 'ios' ? 90 : 0}
    >
      <FlatList
        ref={flatListRef}
        data={messages}
        keyExtractor={(_, i) => i.toString()}
        renderItem={renderItem}
        contentContainerStyle={styles.chatArea}
      />

      <View style={styles.inputRow}>
        <TextInput
          style={styles.input}
          value={input}
          onChangeText={setInput}
          placeholder="Type a message…"
          placeholderTextColor="#888"
          onSubmitEditing={sendMessage}
        />
        <TouchableOpacity style={styles.sendBtn} onPress={sendMessage}>
          <PaperPlane size={20} color="#fff" />
        </TouchableOpacity>
      </View>
    </KeyboardAvoidingView>
  )
}

const styles = StyleSheet.create({
  container: { flex: 1, backgroundColor: '#F3F4F6' },
  chatArea: {
    padding: 12
  },
  bubble: {
    marginVertical: 4,
    padding: 10,
    borderRadius: 8,
    maxWidth: '80%'
  },
  userBubble: {
    backgroundColor: '#7C3AED',
    alignSelf: 'flex-end'
  },
  botBubble: {
    backgroundColor: '#fff',
    alignSelf: 'flex-start'
  },
  userText: { color: '#fff' },
  botText: { color: '#000' },
  inputRow: {
    flexDirection: 'row',
    padding: 8,
    borderTopWidth: 1,
    borderColor: '#ddd',
    backgroundColor: '#fff'
  },
  input: {
    flex: 1,
    borderWidth: 1,
    borderColor: '#ccc',
    borderRadius: 20,
    paddingHorizontal: 12,
    paddingVertical: 6,
    marginRight: 8,
    backgroundColor: '#fff'
  },
  sendBtn: {
    backgroundColor: '#7C3AED',
    borderRadius: 20,
    padding: 10,
    justifyContent: 'center',
    alignItems: 'center'
  }
})
