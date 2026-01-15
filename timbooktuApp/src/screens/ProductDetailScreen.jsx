import React, { useMemo, useState } from "react";
import {
  Image,
  Pressable,
  ScrollView,
  StyleSheet,
  Text,
  View,
  useWindowDimensions,
} from "react-native";

import Screen from "../components/Screen";
import { formatMoney, getCategoryTitle } from "../data/mockCatalog";

const palette = {
  bg: "#000000",
  card: "#0d0d0d",
  soft: "#111111",
  border: "#222222",
  ink: "#ffffff",
  muted: "#aaaaaa",
  accent: "#d2cac1",
};

export default function ProductDetailScreen({ route, navigation }) {
  const { width } = useWindowDimensions();
  const product = route.params?.product;
  const [qty, setQty] = useState(1);

  const detail = useMemo(() => {
    if (!product) return null;
    const category = getCategoryTitle(product.categoryId);
    return {
      ...product,
      category,
      description:
        "A curated art piece from independent creators. High-quality finishing and carefully packaged for delivery.",
      shipping: "Ships in 2–5 business days",
      returns: "7-day returns on eligible items",
    };
  }, [product]);

  if (!detail) {
    return (
      <Screen>
        <View style={styles.center}>
          <Text style={styles.title}>Product not found</Text>
          <Pressable onPress={() => navigation.goBack()} style={styles.secondaryBtn}>
            <Text style={styles.secondaryBtnText}>Go back</Text>
          </Pressable>
        </View>
      </Screen>
    );
  }

  const imageWidth = Math.min(width - 32, 520);

  return (
    <Screen>
      <ScrollView contentContainerStyle={styles.container}>
        <View style={styles.imageWrap}>
          <Image source={{ uri: detail.imageUrl }} style={[styles.image, { width: imageWidth }]} />
        </View>

        <View style={styles.card}>
          <View style={styles.pillsRow}>
            <View style={styles.pill}>
              <Text style={styles.pillText}>{detail.category}</Text>
            </View>
            <View style={styles.pillSoft}>
              <Text style={styles.pillSoftText}>
                {detail.rating.toFixed(1)} • {detail.reviewCount} reviews
              </Text>
            </View>
          </View>

          <Text style={styles.name}>{detail.name}</Text>
          <Text style={styles.price}>{formatMoney(detail.price, detail.currency)}</Text>

          <Text style={styles.sectionTitle}>About</Text>
          <Text style={styles.body}>{detail.description}</Text>

          <View style={styles.infoRow}>
            <View style={styles.infoCell}>
              <Text style={styles.infoLabel}>Shipping</Text>
              <Text style={styles.infoValue}>{detail.shipping}</Text>
            </View>
            <View style={styles.infoCell}>
              <Text style={styles.infoLabel}>Returns</Text>
              <Text style={styles.infoValue}>{detail.returns}</Text>
            </View>
          </View>

          <View style={styles.qtyRow}>
            <Text style={styles.qtyLabel}>Quantity</Text>
            <View style={styles.qtyControls}>
              <Pressable
                style={[styles.qtyBtn, qty <= 1 && styles.qtyBtnDisabled]}
                onPress={() => setQty((q) => Math.max(1, q - 1))}
                accessibilityRole="button"
              >
                <Text style={styles.qtyBtnText}>−</Text>
              </Pressable>
              <Text style={styles.qtyValue}>{qty}</Text>
              <Pressable
                style={styles.qtyBtn}
                onPress={() => setQty((q) => q + 1)}
                accessibilityRole="button"
              >
                <Text style={styles.qtyBtnText}>+</Text>
              </Pressable>
            </View>
          </View>

          <View style={styles.ctaRow}>
            <Pressable style={styles.secondaryBtn} accessibilityRole="button">
              <Text style={styles.secondaryBtnText}>Add to wishlist</Text>
            </Pressable>
            <Pressable style={styles.primaryBtn} accessibilityRole="button">
              <Text style={styles.primaryBtnText}>Add to cart</Text>
            </Pressable>
          </View>
        </View>
      </ScrollView>
    </Screen>
  );
}

const styles = StyleSheet.create({
  container: { padding: 16, paddingBottom: 24 },
  imageWrap: { alignItems: "center" },
  image: {
    height: undefined,
    aspectRatio: 1,
    borderRadius: 18,
    backgroundColor: palette.soft,
  },
  card: {
    marginTop: 16,
    borderWidth: 1,
    borderColor: palette.border,
    borderRadius: 18,
    padding: 16,
    backgroundColor: palette.card,
  },
  pillsRow: { flexDirection: "row", gap: 10, marginBottom: 10, flexWrap: "wrap" },
  pill: {
    backgroundColor: palette.accent,
    paddingHorizontal: 12,
    paddingVertical: 8,
    borderRadius: 999,
  },
  pillText: { color: "#000000", fontFamily: "Inter_600SemiBold", fontSize: 12 },
  pillSoft: {
    backgroundColor: palette.soft,
    borderWidth: 1,
    borderColor: palette.border,
    paddingHorizontal: 12,
    paddingVertical: 8,
    borderRadius: 999,
  },
  pillSoftText: { color: palette.ink, fontFamily: "Inter_400Regular", fontSize: 12 },
  name: { fontSize: 20, color: palette.ink, fontFamily: "PlayfairDisplay_600SemiBold" },
  price: { marginTop: 8, fontSize: 18, color: palette.accent, fontFamily: "Inter_600SemiBold" },
  sectionTitle: { marginTop: 14, fontSize: 14, color: palette.ink, fontFamily: "Chango_400Regular" },
  body: { marginTop: 8, fontSize: 13, lineHeight: 19, color: palette.muted, fontFamily: "DellaRespira_400Regular" },
  infoRow: { marginTop: 16, flexDirection: "row", gap: 12 },
  infoCell: {
    flex: 1,
    backgroundColor: palette.soft,
    borderWidth: 1,
    borderColor: palette.border,
    borderRadius: 14,
    padding: 12,
  },
  infoLabel: { fontSize: 12, color: palette.muted, fontFamily: "Inter_400Regular" },
  infoValue: { marginTop: 6, fontSize: 12, color: palette.ink, fontFamily: "Inter_600SemiBold" },
  qtyRow: { marginTop: 18, flexDirection: "row", justifyContent: "space-between", alignItems: "center" },
  qtyLabel: { color: palette.ink, fontSize: 13, fontFamily: "Inter_600SemiBold" },
  qtyControls: { flexDirection: "row", alignItems: "center", gap: 10 },
  qtyBtn: {
    width: 40,
    height: 40,
    borderRadius: 12,
    borderWidth: 1,
    borderColor: palette.border,
    backgroundColor: palette.soft,
    alignItems: "center",
    justifyContent: "center",
  },
  qtyBtnDisabled: { opacity: 0.4 },
  qtyBtnText: { fontSize: 20, color: palette.ink, marginTop: -2, fontFamily: "Inter_600SemiBold" },
  qtyValue: { minWidth: 24, textAlign: "center", color: palette.ink, fontFamily: "Inter_600SemiBold" },
  ctaRow: { marginTop: 18, flexDirection: "row", gap: 12 },
  primaryBtn: {
    flex: 1,
    backgroundColor: palette.accent,
    paddingVertical: 14,
    borderRadius: 14,
    alignItems: "center",
  },
  primaryBtnText: { color: "#000000", fontFamily: "Inter_600SemiBold" },
  secondaryBtn: {
    flex: 1,
    backgroundColor: palette.soft,
    borderWidth: 1,
    borderColor: palette.border,
    paddingVertical: 14,
    borderRadius: 14,
    alignItems: "center",
  },
  secondaryBtnText: { color: palette.ink, fontFamily: "Inter_600SemiBold" },
  center: { flex: 1, alignItems: "center", justifyContent: "center", padding: 16, gap: 14 },
  title: { color: palette.ink, fontSize: 18, fontFamily: "Chango_400Regular" },
});

