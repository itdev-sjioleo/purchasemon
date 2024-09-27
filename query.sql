-- SALDO AWAL
SELECT
	ic_i.ItemName,
	ap_pd.Quantity as saldo_awal
FROM IC_Items ic_i
LEFT JOIN AP_PurchaseDetails ap_pd ON ap_pd.ItemID = ic_i.ItemID
LEFT JOIN AP_Purchases ap_p ON ap_p.PurchaseID = ap_pd.PurchaseID
WHERE ic_i.ItemCode = 'FUEL-00004' AND ap_p.PurchaseDate > '2023-12-31' AND ap_p.Void = 0
ORDER BY ap_p.PurchaseDate ASC
OFFSET 0 ROWS FETCH FIRST 1 ROWS ONLY;

-- GOODS RECEIVING
WITH gr(item_name, quantity, purchase_date) AS (
	SELECT
		ic_i.ItemName,
		ap_pd.Quantity,
		ap_p.PurchaseDate
	FROM IC_Items ic_i
	LEFT JOIN AP_PurchaseDetails ap_pd ON ap_pd.ItemID = ic_i.ItemID
	LEFT JOIN AP_Purchases ap_p ON ap_p.PurchaseID = ap_pd.PurchaseID
	WHERE ic_i.ItemCode = 'FUEL-00004' AND ap_p.PurchaseDate > '2023-12-31' AND ap_p.Void = 0
)
SELECT 
	item_name, 
	SUM(quantity) as barang_masuk
FROM gr
GROUP BY item_name;

-- INVENTORY USAGE
WITH ius(item_name, quantity, usage_date) AS (
	SELECT
		ic_i.ItemName,
		ic_ud.Quantity,
		ic_u.UsageDate
	FROM IC_Items ic_i
	LEFT JOIN IC_UsageDetails ic_ud on ic_ud.ItemID = ic_i.ItemID
	LEFT JOIN IC_Usages ic_u on ic_u.UsageID = ic_ud.UsageID
	WHERE ic_i.ItemCode = 'FUEL-00004' AND ic_u.UsageDate > '2023-12-31' AND ic_u.Void = 0
) 
SELECT 
	item_name, 
	SUM(quantity) as barang_keluar
FROM ius
GROUP BY item_name;

-- FINAL QUERY
WITH warehouse(item_code, item_name, weight_unit, starting_balance, receiption_qty, expenditure_qty) AS (
	SELECT
		ic_i.ItemCode,
		ic_i.ItemName,
		ic_i.WeightUnit,
		(
			SELECT
				ap_pd_b.Quantity as saldo_awal
			FROM IC_Items ic_i_b
			LEFT JOIN AP_PurchaseDetails ap_pd_b ON ap_pd_b.ItemID = ic_i_b.ItemID
			LEFT JOIN AP_Purchases ap_p_b ON ap_p_b.PurchaseID = ap_pd_b.PurchaseID
			WHERE ic_i_b.ItemCode = ic_i.ItemCode AND ap_p_b.PurchaseDate > '2023-12-31' AND ap_p_b.Void = 0
			ORDER BY ap_p_b.PurchaseDate ASC
			OFFSET 0 ROWS FETCH FIRST 1 ROWS ONLY
		) as saldo_awal,
		(
			SELECT
				sum(ap_pd_b.Quantity)
			FROM IC_Items ic_i_b
			LEFT JOIN AP_PurchaseDetails ap_pd_b ON ap_pd_b.ItemID = ic_i_b.ItemID
			LEFT JOIN AP_Purchases ap_p_b ON ap_p_b.PurchaseID = ap_pd_b.PurchaseID
			WHERE ic_i_b.ItemCode = ic_i.ItemCode AND ap_p_b.PurchaseDate > '2023-12-31' AND ap_p_b.Void = 0
		) as barang_masuk,
		(
			SELECT
				sum(ic_ud_b.Quantity)
			FROM IC_Items ic_i_b
			LEFT JOIN IC_UsageDetails ic_ud_b on ic_ud_b.ItemID = ic_i_b.ItemID
			LEFT JOIN IC_Usages ic_u_b on ic_u_b.UsageID = ic_ud_b.UsageID
			WHERE ic_i_b.ItemCode = ic_i.ItemCode AND ic_u_b.UsageDate > '2023-12-31' AND ic_u_b.Void = 0
		) as barang_keluar
	FROM IC_Items ic_i
)
SELECT
	item_code, 
	item_name, 
	weight_unit, 
	starting_balance, 
	receiption_qty, 
	expenditure_qty,
	(receiption_qty - expenditure_qty) as ending_balance
FROM warehouse
WHERE item_code = 'FUEL-00001'
	OR item_code = 'FUEL-00002'
	OR item_code = 'FUEL-00003'
	OR item_code = 'FUEL-00004';