import React from "react";
import {
  Keyboard,
  KeyboardAvoidingView,
  Platform,
  Pressable,
  StyleSheet,
  View,
} from "react-native";
import { SafeAreaView } from "react-native-safe-area-context";

export default function Screen({
  children,
  style,
  edges = ["top", "bottom"],
  keyboardSafe = true,
}) {
  const web = Platform.OS === "web";

  const content = (
    <Pressable style={styles.pressable} onPress={Keyboard.dismiss}>
      <View style={[styles.container, web && styles.webContainer, style]}>
        {children}
      </View>
    </Pressable>
  );

  return (
    <SafeAreaView style={styles.safeArea} edges={edges}>
      {keyboardSafe ? (
        <KeyboardAvoidingView
          style={styles.keyboardAvoiding}
          behavior={Platform.OS === "ios" ? "padding" : undefined}
        >
          {content}
        </KeyboardAvoidingView>
      ) : (
        content
      )}
    </SafeAreaView>
  );
}

const styles = StyleSheet.create({
  safeArea: { flex: 1, backgroundColor: "#000000" },
  keyboardAvoiding: { flex: 1 },
  pressable: { flex: 1 },
  container: { flex: 1, backgroundColor: "#000000" },
  webContainer: { width: "100%", maxWidth: 430, alignSelf: "center" },
});
