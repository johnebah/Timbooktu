import React from "react";
import { StatusBar } from "expo-status-bar";
import { Stack } from "expo-router";
import * as SplashScreen from "expo-splash-screen";
import { Text, View } from "react-native";
import { SafeAreaProvider } from "react-native-safe-area-context";
import { useFonts } from "expo-font";
import { Inter_400Regular, Inter_600SemiBold } from "@expo-google-fonts/inter";
import { FredokaOne_400Regular } from "@expo-google-fonts/fredoka-one";
import { Chango_400Regular } from "@expo-google-fonts/chango";
import { DellaRespira_400Regular } from "@expo-google-fonts/della-respira";
import {
  PlayfairDisplay_400Regular,
  PlayfairDisplay_600SemiBold,
} from "@expo-google-fonts/playfair-display";

SplashScreen.preventAutoHideAsync().catch(() => {});

export default function RootLayout() {
  const [loaded] = useFonts({
    Inter_400Regular,
    Inter_600SemiBold,
    FredokaOne_400Regular,
    Chango_400Regular,
    DellaRespira_400Regular,
    PlayfairDisplay_400Regular,
    PlayfairDisplay_600SemiBold,
  });
  const [allowRender, setAllowRender] = React.useState(false);

  React.useEffect(() => {
    if (loaded) {
      setAllowRender(true);
      return;
    }

    const timeout = setTimeout(() => {
      setAllowRender(true);
    }, 4000);

    return () => clearTimeout(timeout);
  }, [loaded]);

  React.useEffect(() => {
    if (!allowRender) return;
    SplashScreen.hideAsync().catch(() => {});
  }, [allowRender]);

  if (!allowRender) {
    return (
      <SafeAreaProvider>
        <View
          style={{
            flex: 1,
            alignItems: "center",
            justifyContent: "center",
            backgroundColor: "#DDD6CC",
          }}
        >
          <Text style={{ color: "#101828", fontSize: 16 }}>Loading…</Text>
        </View>
      </SafeAreaProvider>
    );
  }

  return (
    <SafeAreaProvider>
      <StatusBar style="light" />
      <Stack
        screenOptions={{
          headerTitleAlign: "center",
          headerTitleStyle: { fontFamily: "Inter_600SemiBold" },
        }}
      >
        <Stack.Screen name="(tabs)" options={{ headerShown: false }} />
        <Stack.Screen name="product/[id]" options={{ title: "Product" }} />
      </Stack>
    </SafeAreaProvider>
  );
}
