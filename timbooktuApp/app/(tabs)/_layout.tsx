import React from "react";
import { Tabs } from "expo-router";
import Ionicons from "@expo/vector-icons/Ionicons";
import { useSafeAreaInsets } from "react-native-safe-area-context";

const tabIcons: Record<string, { focused: string; unfocused: string }> = {
  index: { focused: "home", unfocused: "home-outline" },
  search: { focused: "search", unfocused: "search-outline" },
  cart: { focused: "cart", unfocused: "cart-outline" },
  account: { focused: "person", unfocused: "person-outline" },
};

export default function TabsLayout() {
  const insets = useSafeAreaInsets();

  return (
    <Tabs
      screenOptions={({ route }) => {
        const icons = tabIcons[route.name] ?? tabIcons.index;
        const baseHeight = 56;
        const bottomInset = insets.bottom;
        const paddingBottom = Math.max(10, bottomInset);

        return {
          headerTitleAlign: "center",
          headerStyle: { backgroundColor: "#000000" },
          headerTintColor: "#ffffff",
          headerTitleStyle: { fontFamily: "Chango_400Regular" },
          tabBarHideOnKeyboard: true,
          tabBarActiveTintColor: "#d2cac1",
          tabBarInactiveTintColor: "#9b9b9b",
          tabBarStyle: {
            height: baseHeight + bottomInset,
            paddingBottom,
            paddingTop: 6,
            backgroundColor: "#000000",
            borderTopColor: "#222222",
          },
          tabBarIcon: ({ focused, color, size }) => (
            <Ionicons
              name={(focused ? icons.focused : icons.unfocused) as any}
              size={size ?? 22}
              color={color}
            />
          ),
        };
      }}
    >
      <Tabs.Screen name="index" options={{ title: "Shop" }} />
      <Tabs.Screen name="search" options={{ title: "Search" }} />
      <Tabs.Screen name="cart" options={{ title: "Cart" }} />
      <Tabs.Screen name="account" options={{ title: "Account" }} />
    </Tabs>
  );
}
