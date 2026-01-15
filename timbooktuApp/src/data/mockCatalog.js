export const categories = [
  { id: 'painting', title: 'Painting' },
  { id: 'photography', title: 'Photography' },
  { id: 'prints', title: 'Prints' },
  { id: 'sculpture', title: 'Sculpture' },
  { id: 'handmade', title: 'Handmade' },
  { id: 'digital', title: 'Digital Art' },
];

export const products = [
  {
    id: 'p-1001',
    name: 'Sunset Over Dunes',
    categoryId: 'painting',
    price: 18500,
    currency: 'NGN',
    rating: 4.7,
    reviewCount: 128,
    imageUrl: 'https://picsum.photos/seed/timbooktu-1001/800/800',
  },
  {
    id: 'p-1002',
    name: 'City Light Photograph',
    categoryId: 'photography',
    price: 9000,
    currency: 'NGN',
    rating: 4.5,
    reviewCount: 76,
    imageUrl: 'https://picsum.photos/seed/timbooktu-1002/800/800',
  },
  {
    id: 'p-1003',
    name: 'Minimal Ink Print',
    categoryId: 'prints',
    price: 6500,
    currency: 'NGN',
    rating: 4.2,
    reviewCount: 41,
    imageUrl: 'https://picsum.photos/seed/timbooktu-1003/800/800',
  },
  {
    id: 'p-1004',
    name: 'Clay Form Sculpture',
    categoryId: 'sculpture',
    price: 32000,
    currency: 'NGN',
    rating: 4.8,
    reviewCount: 94,
    imageUrl: 'https://picsum.photos/seed/timbooktu-1004/800/800',
  },
  {
    id: 'p-1005',
    name: 'Handmade Beaded Art',
    categoryId: 'handmade',
    price: 12000,
    currency: 'NGN',
    rating: 4.6,
    reviewCount: 59,
    imageUrl: 'https://picsum.photos/seed/timbooktu-1005/800/800',
  },
  {
    id: 'p-1006',
    name: 'Digital Poster Pack',
    categoryId: 'digital',
    price: 4500,
    currency: 'NGN',
    rating: 4.1,
    reviewCount: 33,
    imageUrl: 'https://picsum.photos/seed/timbooktu-1006/800/800',
  },
  {
    id: 'p-1007',
    name: 'Abstract Color Study',
    categoryId: 'painting',
    price: 21000,
    currency: 'NGN',
    rating: 4.4,
    reviewCount: 88,
    imageUrl: 'https://picsum.photos/seed/timbooktu-1007/800/800',
  },
  {
    id: 'p-1008',
    name: 'Portrait Print Series',
    categoryId: 'prints',
    price: 7800,
    currency: 'NGN',
    rating: 4.3,
    reviewCount: 52,
    imageUrl: 'https://picsum.photos/seed/timbooktu-1008/800/800',
  },
  {
    id: 'p-1009',
    name: 'Black & White Street Photo',
    categoryId: 'photography',
    price: 10500,
    currency: 'NGN',
    rating: 4.6,
    reviewCount: 67,
    imageUrl: 'https://picsum.photos/seed/timbooktu-1009/800/800',
  },
  {
    id: 'p-1010',
    name: 'Wood Carving Piece',
    categoryId: 'handmade',
    price: 27000,
    currency: 'NGN',
    rating: 4.9,
    reviewCount: 142,
    imageUrl: 'https://picsum.photos/seed/timbooktu-1010/800/800',
  },
];

export function getCategoryTitle(categoryId) {
  return categories.find((c) => c.id === categoryId)?.title ?? 'Art';
}

export function formatMoney(amount, currency = 'NGN') {
  try {
    return new Intl.NumberFormat('en-NG', {
      style: 'currency',
      currency,
      maximumFractionDigits: 0,
    }).format(amount);
  } catch {
    return `${currency} ${amount}`;
  }
}

