import React, { useMemo, useState } from "react";
import {
  FlatList,
  Image,
  Pressable,
  StyleSheet,
  Text,
  View,
} from "react-native";

import Screen from "../components/Screen";
import { products, formatMoney } from "../data/mockCatalog";

const palette = {
  bg: "#000000",
  card: "#0d0d0d",
  soft: "#111111",
  border: "#222222",
  ink: "#ffffff",
  muted: "#aaaaaa",
  accent: "#d2cac1",
};

export default function CartScreen() {
  const [items, setItems] = useState([
    { productId: "p-1001", qty: 1 },
    { productId: "p-1005", qty: 2 },
  ]);

  const rows = useMemo(() => {
    return items
      .map((it) => {
        const product = products.find((p) => p.id === it.productId);
        if (!product) return null;
        return { ...it, product };
      })
      .filter(Boolean);
  }, [items]);

  const subtotal = useMemo(() => {
    return rows.reduce((sum, r) => sum + r.product.price * r.qty, 0);
  }, [rows]);

  const delivery = rows.length === 0 ? 0 : 1500;
  const total = subtotal + delivery;

  return (
    <Screen>
      <View style={styles.header}>
        <Text style={styles.title}>Cart</Text>
        <Text style={styles.subtitle}>Review your items before checkout</Text>
      </View>

      <FlatList
        data={rows}
        keyExtractor={(item) => item.product.id}
        contentContainerStyle={styles.list}
        renderItem={({ item }) => (
          <CartRow
            row={item}
            onDec={() =>
              setItems((prev) =>
                prev
                  .map((p) =>
                    p.productId !== item.product.id
                      ? p
                      : { ...p, qty: Math.max(1, p.qty - 1) }
                  )
                  .filter(Boolean)
              )
            }
            onInc={() =>
              setItems((prev) =>
                prev.map((p) =>
                  p.productId !== item.product.id ? p : { ...p, qty: p.qty + 1 }
                )
              )
            }
            onRemove={() =>
              setItems((prev) =>
                prev.filter((p) => p.productId !== item.product.id)
              )
            }
          />
        )}
        ListEmptyComponent={
          <View style={styles.empty}>
            <Text style={styles.emptyTitle}>Your cart is empty</Text>
            <Text style={styles.emptyBody}>
              Browse products and add your favorites.
            </Text>
          </View>
        }
      />

      <View style={styles.summary}>
        <View style={styles.summaryRow}>
          <Text style={styles.summaryLabel}>Subtotal</Text>
          <Text style={styles.summaryValue}>
            {formatMoney(subtotal, "NGN")}
          </Text>
        </View>
        <View style={styles.summaryRow}>
          <Text style={styles.summaryLabel}>Delivery</Text>
          <Text style={styles.summaryValue}>
            {formatMoney(delivery, "NGN")}
          </Text>
        </View>
        <View style={styles.divider} />
        <View style={styles.summaryRow}>
          <Text style={styles.totalLabel}>Total</Text>
          <Text style={styles.totalValue}>{formatMoney(total, "NGN")}</Text>
        </View>
        <Pressable
          style={[
            styles.checkoutBtn,
            rows.length === 0 && styles.checkoutBtnDisabled,
          ]}
          accessibilityRole="button"
        >
          <Text style={styles.checkoutText}>Checkout</Text>
        </Pressable>
      </View>
    </Screen>
  );
}

function CartRow({ row, onDec, onInc, onRemove }) {
  return (
    <View style={styles.row}>
      <View style={styles.thumb}>
        <Image
          source={{ uri: row.product.imageUrl }}
          style={styles.thumbImage}
        />
      </View>
      <View style={styles.rowInfo}>
        <Text numberOfLines={2} style={styles.rowTitle}>
          {row.product.name}
        </Text>
        <Text style={styles.rowPrice}>
          {formatMoney(row.product.price, row.product.currency)}
        </Text>

        <View style={styles.rowActions}>
          <View style={styles.qty}>
            <Pressable
              style={[styles.qtyBtn, row.qty <= 1 && styles.qtyBtnDisabled]}
              onPress={onDec}
              accessibilityRole="button"
            >
              <Text style={styles.qtyBtnText}>−</Text>
            </Pressable>
            <Text style={styles.qtyValue}>{row.qty}</Text>
            <Pressable
              style={styles.qtyBtn}
              onPress={onInc}
              accessibilityRole="button"
            >
              <Text style={styles.qtyBtnText}>+</Text>
            </Pressable>
          </View>
          <Pressable onPress={onRemove} accessibilityRole="button">
            <Text style={styles.remove}>Remove</Text>
          </Pressable>
        </View>
      </View>
    </View>
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
  list: { paddingHorizontal: 16, paddingBottom: 8 },
  row: {
    flexDirection: "row",
    gap: 12,
    borderWidth: 1,
    borderColor: palette.border,
    backgroundColor: palette.card,
    borderRadius: 16,
    overflow: "hidden",
    marginBottom: 12,
  },
  thumb: { width: 96, aspectRatio: 1, backgroundColor: palette.soft },
  thumbImage: { width: "100%", height: "100%" },
  rowInfo: { flex: 1, paddingVertical: 12, paddingRight: 12 },
  rowTitle: {
    color: palette.ink,
    fontFamily: "Inter_600SemiBold",
    fontSize: 13,
    lineHeight: 18,
  },
  rowPrice: {
    marginTop: 8,
    color: palette.accent,
    fontFamily: "Inter_600SemiBold",
    fontSize: 13,
  },
  rowActions: {
    marginTop: 10,
    flexDirection: "row",
    alignItems: "center",
    justifyContent: "space-between",
  },
  qty: { flexDirection: "row", alignItems: "center", gap: 10 },
  qtyBtn: {
    width: 36,
    height: 36,
    borderRadius: 12,
    borderWidth: 1,
    borderColor: palette.border,
    alignItems: "center",
    justifyContent: "center",
    backgroundColor: palette.soft,
  },
  qtyBtnDisabled: { opacity: 0.4 },
  qtyBtnText: {
    fontSize: 18,
    color: palette.ink,
    marginTop: -2,
    fontFamily: "Inter_600SemiBold",
  },
  qtyValue: {
    minWidth: 22,
    textAlign: "center",
    color: palette.ink,
    fontFamily: "Inter_600SemiBold",
  },
  remove: {
    color: palette.muted,
    fontFamily: "Inter_600SemiBold",
    fontSize: 12,
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
  summary: {
    borderTopWidth: 1,
    borderTopColor: palette.border,
    paddingHorizontal: 16,
    paddingTop: 12,
    paddingBottom: 14,
    backgroundColor: palette.soft,
  },
  summaryRow: {
    flexDirection: "row",
    justifyContent: "space-between",
    paddingVertical: 4,
  },
  summaryLabel: {
    color: palette.muted,
    fontFamily: "Inter_400Regular",
    fontSize: 12,
  },
  summaryValue: {
    color: palette.ink,
    fontFamily: "Inter_600SemiBold",
    fontSize: 12,
  },
  divider: { height: 1, backgroundColor: palette.border, marginVertical: 10 },
  totalLabel: {
    color: palette.ink,
    fontFamily: "Inter_600SemiBold",
    fontSize: 14,
  },
  totalValue: {
    color: palette.accent,
    fontFamily: "Inter_600SemiBold",
    fontSize: 14,
  },
  checkoutBtn: {
    marginTop: 12,
    backgroundColor: palette.accent,
    borderRadius: 14,
    paddingVertical: 14,
    alignItems: "center",
  },
  checkoutBtnDisabled: { opacity: 0.5 },
  checkoutText: { color: "#000000", fontFamily: "Inter_600SemiBold" },
});
