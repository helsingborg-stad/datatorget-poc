
# Deploy a FRENDS Agent to Kubernetes

This package contains the base configuration for creating a FRENDS Agent in Kubernetes. The "Deployment Options" section below describes some of the additional configuration scenarios available.

The following resources will be created in Kubernetes

- Kubernetes Namespace based on ```TenantName-AgentGroupName```
- FRENDS Agent Secret containing application settings
- FRENDS Agent replica set containing one or more Agent Pods
- Service used to expose FRENDS Agent Pod endpoints

## Deployment Options

Prior to deployment the following configuration options should be considered.

### Persisted-System Volume (Dev/Test only)

By default the FRENDS Agent Database and Processes are stored locally on each Agent Pod. This means when a Pod is destroyed so is any transient data.

A persisted-system volume mount can be used to store the FRENDS Agents Database and Processes outside the pod ensuring it is persisted in the event of a restart/termination.

For more information and configuration examples see [FRENDS Agent Volume Mounts](https://docs.frends.com/en/articles/4031540-frends-agent-volume-mounts)

#### WARNING : This option is only intended to be used in Development and Testing. For Production Environments we recommend using a Shared State Store instead (see below)

### Persisted-Data Volume (Dev/Test/Prod)

The persisted-data volume is used to mount an external file system which can be used by the Agent to store and retrieve FRENDS Process data outside the pod.

For more information and configuration examples see [FRENDS Agent Volume Mounts](https://docs.frends.com/en/articles/4031540-frends-agent-volume-mounts)

### Shared State Store & High Availability (Recommended for Production)

The Shared State Store is the recommended way to persist Agent configuration data outside the Agent Pod.

When using multiple FRENDS Agents in High Availability the Shared State Store is used orchestrates File Watch, Schedule and Conditional Triggers.

The Shared State Store can be configured as a Microsoft SQL Server Database or an ETCD Cluster

For more information and configuration examples see [FRENDS Agent Shared State Store & High Availability](https://docs.frends.com/en/articles/4031559-frends-agent-shared-state-store-high-availability)

### HTTP/API Endpoint SSL Certificates (Dev/Test/Prod)

By default the FRENDS Agent Generates self signed certificates for API and HTTP endpoints.

It is also possible to secure API and HTTP endpoints with your own SSL certificates

For more information and configuration examples see [FRENDS Agent HTTP/API Endpoint SSL Certificates](https://docs.frends.com/en/articles/4031568-frends-agent-http-api-endpoint-ssl-certificates)

### CPU/Memory Limits and Requests (Dev/Test/Prod)

We've included some example CPU and Memory limits and requests in this configuration

It is recommended that appropriate resource limits be established specific to your own FRENDS Agents through testing and monitoring.

For more information and configuration examples see [FRENDS Agent Memory and CPU limits](https://docs.frends.com/en/articles/4031570-frends-agent-memory-and-cpu-limits)

## Deployment

The following section covers the kubectl commands used to deploy resources to kubernetes

### Create an AgentGroup specific Namespace

We recommend deploying FRENDS Agents into a Namespace based on their AgentGroup

```kubectl create namespace helsingborg-onpremisetest```

### Create FRENDS Agent Secrets in AgentGroup Namespace

```kubectl -n helsingborg-onpremisetest create secret generic frends-agent-secrets --from-file=.\secrets```

### Deploy FRENDS Agent in AgentGroup Namespace

```kubectl -n helsingborg-onpremisetest apply -f .\frends-agent-deploy.yaml```

## Troubleshooting/Useful Commands

### Check FRENDS Agent logs

```kubectl logs -f deployment/frends-agent-linux -n helsingborg-onpremisetest --max-log-requests=10```
