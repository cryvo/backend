# k8s/namespace.yaml
apiVersion: v1
kind: Namespace
metadata:
  name: cryvo
---
# k8s/configmap.yaml
apiVersion: v1
kind: ConfigMap
metadata:
  name: cryvo-config
  namespace: cryvo
data:
  APP_ENV: "production"
  APP_DEBUG: "false"
  NEXT_PUBLIC_RPC_URL: "https://mainnet.infura.io/v3/${INFURA_KEY}"
  ANALYTICS_SERVICE_URL: "http://analytics-service:4000"
  MATCHING_ENGINE_URL: "http://matching-engine:3002"
