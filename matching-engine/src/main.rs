use actix_web::{web, App, HttpResponse, HttpServer, Responder};
use serde::{Deserialize, Serialize};
use std::sync::Mutex;
use std::collections::HashMap;

#[derive(Serialize, Deserialize, Clone)]
struct Order {
    id: u64,
    symbol: String,
    side: String,
    price: f64,
    amount: f64,
}

#[derive(Serialize, Deserialize, Clone)]
struct OrderBook {
    bids: Vec<(f64, f64)>,
    asks: Vec<(f64, f64)>,
}

struct AppState {
    order_books: Mutex<HashMap<String, OrderBook>>,
}

async fn get_orderbook(
    data: web::Data<AppState>,
    path: web::Path<String>
) -> impl Responder {
    let symbol = path.into_inner();
    let books = data.order_books.lock().unwrap();
    let ob = books.get(&symbol)
        .cloned()
        .unwrap_or(OrderBook { bids: vec![], asks: vec![] });
    HttpResponse::Ok().json(ob)
}

async fn place_order(
    data: web::Data<AppState>,
    payload: web::Json<Order>
) -> impl Responder {
    let mut books = data.order_books.lock().unwrap();
    let ob = books.entry(payload.symbol.clone())
        .or_insert(OrderBook { bids: vec![], asks: vec![] });

    // **STUB**: simple append; replace with real matching logic
    if payload.side == "buy" {
        ob.bids.push((payload.price, payload.amount));
    } else {
        ob.asks.push((payload.price, payload.amount));
    }

    HttpResponse::Ok().json(payload.into_inner())
}

#[actix_web::main]
async fn main() -> std::io::Result<()> {
    let state = web::Data::new(AppState {
        order_books: Mutex::new(HashMap::new()),
    });

    HttpServer::new(move || {
        App::new()
            .app_data(state.clone())
            .route("/orderbook/{symbol}", web::get().to(get_orderbook))
            .route("/order", web::post().to(place_order))
    })
    .bind(("0.0.0.0", 3002))?
    .run()
    .await
}
