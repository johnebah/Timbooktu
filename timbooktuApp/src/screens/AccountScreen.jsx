import React, { useMemo, useState } from "react";
import { Pressable, StyleSheet, Text, TextInput, View } from "react-native";

import Screen from "../components/Screen";

const palette = {
  bg: "#000000",
  card: "#0d0d0d",
  soft: "#111111",
  border: "#222222",
  ink: "#ffffff",
  muted: "#aaaaaa",
  accent: "#d2cac1",
};

export default function AccountScreen() {
  const [mode, setMode] = useState("signin");
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [fullName, setFullName] = useState("");

  const cta = useMemo(
    () => (mode === "signin" ? "Sign in" : "Create account"),
    [mode]
  );

  return (
    <Screen>
      <View style={styles.header}>
        <Text style={styles.title}>Account</Text>
        <Text style={styles.subtitle}>
          Sign in to track orders and save items
        </Text>
      </View>

      <View style={styles.switchRow}>
        <Pressable
          style={[
            styles.switchBtn,
            mode === "signin" && styles.switchBtnActive,
          ]}
          onPress={() => setMode("signin")}
          accessibilityRole="button"
        >
          <Text
            style={[
              styles.switchText,
              mode === "signin" && styles.switchTextActive,
            ]}
          >
            Sign in
          </Text>
        </Pressable>
        <Pressable
          style={[
            styles.switchBtn,
            mode === "signup" && styles.switchBtnActive,
          ]}
          onPress={() => setMode("signup")}
          accessibilityRole="button"
        >
          <Text
            style={[
              styles.switchText,
              mode === "signup" && styles.switchTextActive,
            ]}
          >
            Sign up
          </Text>
        </Pressable>
      </View>

      <View style={styles.form}>
        {mode === "signup" ? (
          <TextInput
            value={fullName}
            onChangeText={setFullName}
            placeholder="Full name"
            placeholderTextColor="#999999"
            style={styles.input}
            autoCapitalize="words"
            returnKeyType="next"
          />
        ) : null}

        <TextInput
          value={email}
          onChangeText={setEmail}
          placeholder="Email"
          placeholderTextColor="#999999"
          style={styles.input}
          autoCapitalize="none"
          keyboardType="email-address"
          returnKeyType="next"
        />

        <TextInput
          value={password}
          onChangeText={setPassword}
          placeholder="Password"
          placeholderTextColor="#999999"
          style={styles.input}
          secureTextEntry
          returnKeyType="done"
        />

        <Pressable style={styles.primaryBtn} accessibilityRole="button">
          <Text style={styles.primaryBtnText}>{cta}</Text>
        </Pressable>

        <View style={styles.helpRow}>
          <Pressable accessibilityRole="button">
            <Text style={styles.helpLink}>Forgot password?</Text>
          </Pressable>
          <Pressable accessibilityRole="button">
            <Text style={styles.helpLink}>Support</Text>
          </Pressable>
        </View>

        <View style={styles.card}>
          <Text style={styles.cardTitle}>Prototype notes</Text>
          <Text style={styles.cardBody}>
            This screen is UI-only for now. Next step is connecting to your
            Laravel API for auth and orders.
          </Text>
        </View>
      </View>
    </Screen>
  );
}

const styles = StyleSheet.create({
  header: { paddingHorizontal: 16, paddingTop: 12, paddingBottom: 10 },
  title: { fontSize: 20, color: palette.ink, fontFamily: "Chango_400Regular" },
  subtitle: {
    marginTop: 6,
    fontSize: 12,
    color: palette.muted,
    fontFamily: "DellaRespira_400Regular",
  },
  switchRow: {
    flexDirection: "row",
    gap: 10,
    paddingHorizontal: 16,
    paddingBottom: 10,
  },
  switchBtn: {
    flex: 1,
    borderWidth: 1,
    borderColor: palette.border,
    borderRadius: 14,
    paddingVertical: 12,
    alignItems: "center",
    backgroundColor: palette.soft,
  },
  switchBtnActive: {
    backgroundColor: palette.accent,
    borderColor: palette.accent,
  },
  switchText: { color: palette.ink, fontFamily: "Inter_600SemiBold" },
  switchTextActive: { color: "#000000" },
  form: { paddingHorizontal: 16, gap: 12, paddingTop: 6 },
  input: {
    height: 48,
    borderWidth: 1,
    borderColor: "#333333",
    borderRadius: 14,
    paddingHorizontal: 14,
    backgroundColor: "transparent",
    color: palette.ink,
    fontFamily: "Inter_400Regular",
  },
  primaryBtn: {
    marginTop: 6,
    backgroundColor: palette.accent,
    borderRadius: 14,
    paddingVertical: 14,
    alignItems: "center",
  },
  primaryBtnText: { color: "#000000", fontFamily: "Inter_600SemiBold" },
  helpRow: {
    flexDirection: "row",
    justifyContent: "space-between",
    marginTop: 4,
  },
  helpLink: {
    color: palette.accent,
    fontFamily: "Inter_600SemiBold",
    fontSize: 12,
  },
  card: {
    marginTop: 6,
    borderWidth: 1,
    borderColor: palette.border,
    borderRadius: 16,
    padding: 14,
    backgroundColor: palette.card,
  },
  cardTitle: {
    fontSize: 13,
    fontFamily: "Inter_600SemiBold",
    color: palette.ink,
  },
  cardBody: {
    marginTop: 8,
    fontSize: 12,
    color: palette.muted,
    lineHeight: 18,
    fontFamily: "DellaRespira_400Regular",
  },
});
