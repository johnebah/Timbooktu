import React, { useMemo } from "react";
import { useLocalSearchParams, useRouter } from "expo-router";

import ProductDetailScreen from "../../src/screens/ProductDetailScreen.jsx";
import { products } from "../../src/data/mockCatalog";

export default function ProductDetailRoute() {
  const router = useRouter();
  const { id } = useLocalSearchParams();

  const productId = Array.isArray(id) ? id[0] : id;
  const product = useMemo(
    () => products.find((p) => p.id === productId) ?? null,
    [productId]
  );

  return (
    <ProductDetailScreen
      route={{ params: { product } }}
      navigation={{ goBack: router.back }}
    />
  );
}
