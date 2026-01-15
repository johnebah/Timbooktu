import React, { useMemo } from "react";
import {
  FlatList,
  Image,
  Platform,
  Pressable,
  StyleSheet,
  Text,
  TextInput,
  useWindowDimensions,
  View,
} from "react-native";
import { useRouter } from "expo-router";

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
  accent2: "#DDD6CC",
};

function getColumns(width) {
  if (width >= 900) return 4;
  if (width >= 700) return 3;
  return 2;
}

export default function HomeScreen({ navigation }) {
  const router = useRouter();
  const { width } = useWindowDimensions();
  const numColumns = getColumns(width);

  const productData = useMemo(() => products, []);

  const header = (
    <View>
      <View style={styles.topBar}>
        <View>
          <Text style={styles.brandName}>Timbooktu</Text>
          <Text style={styles.subTitle}>Art marketplace</Text>
        </View>
        <View style={styles.topActions}>
          <Pressable style={styles.topActionBtn} accessibilityRole="button">
            <Text style={styles.topActionText}>Deals</Text>
          </Pressable>
          <Pressable style={styles.topActionBtn} accessibilityRole="button">
            <Text style={styles.topActionText}>Help</Text>
          </Pressable>
        </View>
      </View>

      <View style={styles.searchRow}>
        <TextInput
          placeholder="Search art, artists, categories"
          placeholderTextColor="#999999"
          style={styles.searchInput}
          returnKeyType="search"
        />
      </View>

      <View style={styles.banner}>
        <View style={styles.bannerTextWrap}>
          <Text style={styles.bannerTitle}>Discover original art</Text>
          <Text style={styles.bannerSubtitle}>
            Shop limited pieces, prints, and handmade works.
          </Text>
          <Pressable style={styles.bannerBtn} accessibilityRole="button">
            <Text style={styles.bannerBtnText}>Shop now</Text>
          </Pressable>
        </View>
        <View style={styles.bannerArt}>
          <View style={styles.bannerArtBlockA} />
          <View style={styles.bannerArtBlockB} />
          <View style={styles.bannerArtBlockC} />
        </View>
      </View>

      <View style={styles.sectionHeader}>
        <Text style={styles.sectionTitle}>Shop categories</Text>
        <Pressable accessibilityRole="button">
          <Text style={styles.sectionLink}>View all</Text>
        </Pressable>
      </View>

      <FlatList
        horizontal
        showsHorizontalScrollIndicator={false}
        data={categories}
        keyExtractor={(item) => item.id}
        contentContainerStyle={styles.categoryList}
        renderItem={({ item, index }) => (
          <CategoryChip item={item} index={index} />
        )}
      />

      <View style={styles.sectionHeader}>
        <Text style={styles.sectionTitle}>Recommended for you</Text>
        <Pressable accessibilityRole="button">
          <Text style={styles.sectionLink}>See more</Text>
        </Pressable>
      </View>
    </View>
  );

  return (
    <Screen>
      <FlatList
        data={productData}
        key={numColumns}
        numColumns={numColumns}
        keyExtractor={(item) => item.id}
        contentContainerStyle={styles.productList}
        columnWrapperStyle={numColumns > 1 ? styles.column : undefined}
        ListHeaderComponent={header}
        renderItem={({ item }) => (
          <ProductCard
            item={item}
            width={width}
            numColumns={numColumns}
            onPress={() => {
              if (navigation?.navigate) {
                navigation.navigate("ProductDetail", { product: item });
                return;
              }
              router.push({ pathname: "/product/[id]", params: { id: item.id } });
            }}
          />
        )}
      />
    </Screen>
  );
}

function CategoryChip({ item, index }) {
  const swatches = [
    { bg: palette.accent2, ink: "#000000" },
    { bg: palette.accent, ink: "#000000" },
    { bg: "#b0d685", ink: "#000000" },
    { bg: palette.soft, ink: palette.ink },
  ];
  const swatch = swatches[index % swatches.length];

  return (
    <Pressable
      style={[
        styles.categoryChip,
        { backgroundColor: swatch.bg, borderColor: palette.border },
      ]}
      accessibilityRole="button"
    >
      <Text style={[styles.categoryTitle, { color: swatch.ink }]}>
        {item.title}
      </Text>
      <Text style={[styles.categoryMeta, { color: swatch.ink, opacity: 0.8 }]}>
        Shop
      </Text>
    </Pressable>
  );
}

function ProductCard({ item, onPress, width, numColumns }) {
  const gap = 12;
  const horizontalPadding = 16;
  const available = width - horizontalPadding * 2 - gap * (numColumns - 1);
  const cardWidth = Math.floor(available / numColumns);

  return (
    <Pressable
      onPress={onPress}
      style={[styles.productCard, { width: cardWidth }]}
      accessibilityRole="button"
    >
      <View style={styles.productImageWrap}>
        <Image source={{ uri: item.imageUrl }} style={styles.productImage} />
        <View style={styles.badge}>
          <Text style={styles.badgeText}>{getCategoryTitle(item.categoryId)}</Text>
        </View>
      </View>
      <View style={styles.productInfo}>
        <Text numberOfLines={2} style={styles.productName}>
          {item.name}
        </Text>
        <Text style={styles.productPrice}>{formatMoney(item.price, item.currency)}</Text>
        <Text style={styles.productMeta}>
          {item.rating.toFixed(1)} • {item.reviewCount} reviews
        </Text>
      </View>
    </Pressable>
  );
}

const styles = StyleSheet.create({
  topBar: {
    paddingHorizontal: 16,
    paddingTop: 10,
    paddingBottom: 12,
    flexDirection: "row",
    alignItems: "center",
    justifyContent: "space-between",
  },
  brandName: {
    fontSize: 22,
    color: palette.ink,
    fontFamily: "FredokaOne_400Regular",
    letterSpacing: 0.6,
  },
  subTitle: {
    marginTop: 4,
    fontSize: 12,
    color: palette.muted,
    fontFamily: "DellaRespira_400Regular",
  },
  topActions: { flexDirection: "row", gap: 10 },
  topActionBtn: {
    borderWidth: 1,
    borderColor: palette.border,
    paddingVertical: 8,
    paddingHorizontal: 12,
    borderRadius: 999,
    backgroundColor: palette.soft,
  },
  topActionText: {
    color: palette.ink,
    fontSize: 12,
    fontFamily: "Inter_600SemiBold",
  },
  searchRow: { paddingHorizontal: 16, paddingBottom: 14 },
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
  banner: {
    marginHorizontal: 16,
    padding: 16,
    borderRadius: 18,
    backgroundColor: palette.accent2,
    overflow: "hidden",
    flexDirection: "row",
    alignItems: "center",
    justifyContent: "space-between",
    minHeight: 148,
  },
  bannerTextWrap: { flex: 1, paddingRight: 12 },
  bannerTitle: {
    color: "#000000",
    fontSize: 18,
    fontFamily: "Chango_400Regular",
    letterSpacing: 0.2,
  },
  bannerSubtitle: {
    marginTop: 6,
    color: "rgba(0,0,0,0.8)",
    fontSize: 12,
    fontFamily: "DellaRespira_400Regular",
  },
  bannerBtn: {
    marginTop: 12,
    alignSelf: "flex-start",
    backgroundColor: "#000000",
    borderRadius: 999,
    paddingHorizontal: 14,
    paddingVertical: Platform.OS === "ios" ? 10 : 9,
  },
  bannerBtnText: { color: "#ffffff", fontFamily: "Inter_600SemiBold", fontSize: 12 },
  bannerArt: { width: 92, height: 92, position: "relative" },
  bannerArtBlockA: {
    position: "absolute",
    right: -12,
    top: -6,
    width: 64,
    height: 64,
    borderRadius: 18,
    backgroundColor: "#000000",
    opacity: 0.12,
    transform: [{ rotate: "12deg" }],
  },
  bannerArtBlockB: {
    position: "absolute",
    left: 0,
    bottom: -6,
    width: 60,
    height: 60,
    borderRadius: 18,
    backgroundColor: "#b0d685",
    opacity: 0.75,
    transform: [{ rotate: "-10deg" }],
  },
  bannerArtBlockC: {
    position: "absolute",
    left: 26,
    top: 22,
    width: 46,
    height: 46,
    borderRadius: 14,
    backgroundColor: palette.accent,
    opacity: 0.8,
    transform: [{ rotate: "18deg" }],
  },
  sectionHeader: {
    paddingHorizontal: 16,
    paddingTop: 18,
    paddingBottom: 10,
    flexDirection: "row",
    justifyContent: "space-between",
    alignItems: "center",
  },
  sectionTitle: {
    fontSize: 16,
    color: palette.ink,
    fontFamily: "Chango_400Regular",
  },
  sectionLink: { fontSize: 12, color: palette.accent, fontFamily: "Inter_600SemiBold" },
  categoryList: { paddingHorizontal: 16, paddingBottom: 8, gap: 10 },
  categoryChip: {
    width: 140,
    padding: 14,
    borderRadius: 16,
    borderWidth: 1,
  },
  categoryTitle: { fontSize: 14, fontFamily: "Inter_600SemiBold" },
  categoryMeta: { marginTop: 6, fontSize: 12, fontFamily: "Inter_400Regular" },
  productList: { paddingHorizontal: 16, paddingBottom: 18 },
  column: { gap: 12, justifyContent: "space-between" },
  productCard: {
    borderWidth: 1,
    borderColor: palette.border,
    borderRadius: 16,
    overflow: "hidden",
    backgroundColor: palette.card,
    marginBottom: 12,
  },
  productImageWrap: { width: "100%", aspectRatio: 1, backgroundColor: palette.soft },
  productImage: { width: "100%", height: "100%" },
  badge: {
    position: "absolute",
    left: 10,
    top: 10,
    backgroundColor: "rgba(0,0,0,0.7)",
    paddingHorizontal: 10,
    paddingVertical: 6,
    borderRadius: 999,
  },
  badgeText: { fontSize: 11, color: "#ffffff", fontFamily: "Inter_600SemiBold" },
  productInfo: { padding: 12 },
  productName: {
    color: palette.ink,
    fontFamily: "Inter_600SemiBold",
    fontSize: 13,
    lineHeight: 18,
  },
  productPrice: {
    marginTop: 8,
    color: palette.accent,
    fontFamily: "Inter_600SemiBold",
    fontSize: 14,
  },
  productMeta: { marginTop: 6, color: palette.muted, fontSize: 12, fontFamily: "Inter_400Regular" },
});

