import React, { useMemo, useState } from "react";
import {
  FlatList,
  Image,
  Pressable,
  StyleSheet,
  Text,
  TextInput,
  View,
  useWindowDimensions,
} from "react-native";

import Screen from "../components/Screen";
import {
  categories,
  products,
  formatMoney,
  getCategoryTitle,
} from "../data/mockCatalog";

const palette = {
  bg: "#000000",
  card: "#0d0d0d",
  soft: "#111111",
  border: "#222222",
  ink: "#ffffff",
  muted: "#aaaaaa",
  accent: "#d2cac1",
};

export default function SearchScreen() {
  const { width } = useWindowDimensions();
  const [query, setQuery] = useState("");
  const [categoryId, setCategoryId] = useState("all");

  const filtered = useMemo(() => {
    const q = query.trim().toLowerCase();
    return products.filter((p) => {
      const matchesCategory =
        categoryId === "all" ? true : p.categoryId === categoryId;
      const matchesQuery =
        q.length === 0 ? true : p.name.toLowerCase().includes(q);
      return matchesCategory && matchesQuery;
    });
  }, [query, categoryId]);

  const numColumns = width >= 750 ? 2 : 1;

  return (
    <Screen>
      <View style={styles.header}>
        <Text style={styles.title}>Search</Text>
        <Text style={styles.subtitle}>
          Find paintings, prints, photos and more
        </Text>
      </View>

      <View style={styles.searchWrap}>
        <TextInput
          value={query}
          onChangeText={setQuery}
          placeholder="Search products"
          placeholderTextColor="#999999"
          style={styles.searchInput}
          returnKeyType="search"
        />
      </View>

      <FlatList
        horizontal
        showsHorizontalScrollIndicator={false}
        contentContainerStyle={styles.filters}
        data={[{ id: "all", title: "All" }, ...categories]}
        keyExtractor={(item) => item.id}
        renderItem={({ item }) => {
          const active = item.id === categoryId;
          return (
            <Pressable
              onPress={() => setCategoryId(item.id)}
              style={[styles.filterPill, active && styles.filterPillActive]}
              accessibilityRole="button"
            >
              <Text
                style={[styles.filterText, active && styles.filterTextActive]}
              >
                {item.title}
              </Text>
            </Pressable>
          );
        }}
      />

      <FlatList
        data={filtered}
        key={numColumns}
        numColumns={numColumns}
        keyExtractor={(item) => item.id}
        contentContainerStyle={styles.results}
        columnWrapperStyle={numColumns > 1 ? styles.columns : undefined}
        renderItem={({ item }) => <SearchCard item={item} />}
        ListEmptyComponent={
          <View style={styles.empty}>
            <Text style={styles.emptyTitle}>No results</Text>
            <Text style={styles.emptyBody}>
              Try a different search term or category.
            </Text>
          </View>
        }
      />
    </Screen>
  );
}

function SearchCard({ item }) {
  return (
    <Pressable style={styles.card} accessibilityRole="button">
      <View style={styles.thumb}>
        <Image source={{ uri: item.imageUrl }} style={styles.thumbImage} />
      </View>
      <View style={styles.cardInfo}>
        <Text numberOfLines={2} style={styles.cardTitle}>
          {item.name}
        </Text>
        <Text style={styles.cardMeta}>{getCategoryTitle(item.categoryId)}</Text>
        <Text style={styles.cardPrice}>
          {formatMoney(item.price, item.currency)}
        </Text>
      </View>
    </Pressable>
  );
}

const styles = StyleSheet.create({
  header: { paddingHorizontal: 16, paddingTop: 12, paddingBottom: 8 },
  title: { fontSize: 20, color: palette.ink, fontFamily: "Chango_400Regular" },
  subtitle: {
    marginTop: 6,
    fontSize: 12,
    color: palette.muted,
    fontFamily: "DellaRespira_400Regular",
  },
  searchWrap: { paddingHorizontal: 16, paddingBottom: 10 },
  searchInput: {
    height: 46,
    borderWidth: 1,
    borderColor: "#333333",
    borderRadius: 14,
    paddingHorizontal: 14,
    backgroundColor: "transparent",
    color: palette.ink,
    fontFamily: "Inter_400Regular",
  },
  filters: { paddingHorizontal: 16, paddingBottom: 10, gap: 10 },
  filterPill: {
    paddingHorizontal: 12,
    paddingVertical: 8,
    borderRadius: 999,
    borderWidth: 1,
    borderColor: palette.border,
    backgroundColor: palette.soft,
  },
  filterPillActive: {
    backgroundColor: palette.accent,
    borderColor: palette.accent,
  },
  filterText: {
    fontSize: 12,
    fontFamily: "Inter_600SemiBold",
    color: palette.ink,
  },
  filterTextActive: { color: "#000000" },
  results: { paddingHorizontal: 16, paddingBottom: 16 },
  columns: { gap: 12, justifyContent: "space-between" },
  card: {
    flex: 1,
    flexDirection: "row",
    gap: 12,
    borderWidth: 1,
    borderColor: palette.border,
    borderRadius: 16,
    backgroundColor: palette.card,
    overflow: "hidden",
    marginBottom: 12,
  },
  thumb: { width: 92, aspectRatio: 1, backgroundColor: palette.soft },
  thumbImage: { width: "100%", height: "100%" },
  cardInfo: { flex: 1, paddingVertical: 12, paddingRight: 12 },
  cardTitle: {
    color: palette.ink,
    fontSize: 13,
    fontFamily: "Inter_600SemiBold",
    lineHeight: 18,
  },
  cardMeta: {
    marginTop: 6,
    color: palette.muted,
    fontSize: 12,
    fontFamily: "Inter_400Regular",
  },
  cardPrice: {
    marginTop: 8,
    color: palette.accent,
    fontSize: 13,
    fontFamily: "Inter_600SemiBold",
  },
  empty: { padding: 16, alignItems: "center" },
  emptyTitle: {
    color: palette.ink,
    fontSize: 16,
    fontFamily: "Chango_400Regular",
  },
  emptyBody: {
    marginTop: 6,
    color: palette.muted,
    fontSize: 12,
    fontFamily: "DellaRespira_400Regular",
  },
});
