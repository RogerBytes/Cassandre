# test de mermerde

```mermaid
stateDiagram-v2
  state choice_1 <<choice>>
  S1 --> choice_1
  state choice_2 <<choice>>
  choice_1 --> choice_2
  choice_2 --> S2
```
