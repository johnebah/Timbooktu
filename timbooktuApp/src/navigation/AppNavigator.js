import React from 'react';
import { NavigationContainer, DefaultTheme } from '@react-navigation/native';
import { createBottomTabNavigator } from '@react-navigation/bottom-tabs';
import { createNativeStackNavigator } from '@react-navigation/native-stack';
import { enableScreens } from 'react-native-screens';

import HomeScreen from '../screens/HomeScreen';
import ProductDetailScreen from '../screens/ProductDetailScreen';
import SearchScreen from '../screens/SearchScreen';
import CartScreen from '../screens/CartScreen';
import AccountScreen from '../screens/AccountScreen';

enableScreens();

const Tab = createBottomTabNavigator();
const Stack = createNativeStackNavigator();

function HomeStack() {
  return (
    <Stack.Navigator>
      <Stack.Screen
        name="Home"
        component={HomeScreen}
        options={{ headerShown: false }}
      />
      <Stack.Screen
        name="ProductDetail"
        component={ProductDetailScreen}
        options={{ title: 'Product' }}
      />
    </Stack.Navigator>
  );
}

const navTheme = {
  ...DefaultTheme,
  colors: {
    ...DefaultTheme.colors,
    background: '#ffffff',
  },
};

export default function AppNavigator() {
  return (
    <NavigationContainer theme={navTheme}>
      <Tab.Navigator
        screenOptions={{
          headerTitleAlign: 'center',
          tabBarHideOnKeyboard: true,
          tabBarStyle: { height: 62, paddingBottom: 10, paddingTop: 6 },
        }}
      >
        <Tab.Screen
          name="Shop"
          component={HomeStack}
          options={{ headerShown: false }}
        />
        <Tab.Screen
          name="Search"
          component={SearchScreen}
          options={{ title: 'Search' }}
        />
        <Tab.Screen name="Cart" component={CartScreen} options={{ title: 'Cart' }} />
        <Tab.Screen
          name="Account"
          component={AccountScreen}
          options={{ title: 'Account' }}
        />
      </Tab.Navigator>
    </NavigationContainer>
  );
}

