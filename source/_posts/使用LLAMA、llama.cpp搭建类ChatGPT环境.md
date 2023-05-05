---
title: 使用LLAMA、llama.cpp搭建类ChatGPT环境
date: 2023-05-05 20:56:26
tags: ['AI','ChatGPT','LLaMA']
---

ChatGPT劲爆式的出现，使得AI又重新火了一把，又一次将人工智能带到群众面前，人工智能的发展是断断续续曲折的，随着硬件不断升级，这次应该不是昙花一现，有足够的算力来支撑本次时代变革。在ChatGPT聊天交互式的体验中，让我对计算机处理自然语言的能力又一次加深。近期开源社区也发布了很多开源模型，本次搭建一个类ChatGPT的应用，来加深对大语言模型的理解，为后续深入学习人工智能打下基础。  

本次类ChatGPT搭建模型使用Mate原型 LLaMA + Chinese-LLaMA-Alpaca-7B，推理使用llama.cpp。  
 + LLaMA https://github.com/facebookresearch/llama  
LLaMA模型为Mate 发布的模型，现在暂未开源，可以申请获取训练的数据，也可以在网上寻找。模型参数数据包括7B 13B 33B 65B，咱们这次选择最简单的7B参数模型。
 + Chinese-LLaMA-Alpaca https://github.com/ymcui/Chinese-LLaMA-Alpaca  
Chinese-LLaMA-Alpaca 中文LLaMA模型和指令精调的Alpaca大模型,这些模型在原版LLaMA的基础上扩充了中文词表并使用了中文数据进行二次预训练，进一步提升了中文基础语义理解能力,具体可以查询官方GITHUB。
 + llama.cpp https://github.com/ggerganov/llama.cpp
llama.cpp是纯 C/C++开发的LLaMA 模型的推导器，可以使用CPU进行推理，也可以在个人电脑上进行使用，消耗CPU比较明显，交互过程机器中呜呜的作响。

我们可以直接使用llama.cpp去加载Mate的原版参数模型数据，但是为了更好的支持中文交互，我们需要将Chinese-LLaMA-Alpaca中的模型和原版LLAMA的模型进行合并，然后做格式转换，由llama.cpp来推导解析，整个过程包括以下6个步骤：  
+ 1-LLaMA 7B模型下载
+ 2-Chinese-LLaMA-Alpaca 7B中文模型下载
+ 3-原版模型和中文模型进行合并模型
+ 4-模型格式转换，转换为llama.cpp可推导的格式
+ 5-下载llama.cpp,编译安装
+ 6-对模型数据进行测试

步骤1-4可以直接从网上下载，我推荐 https://aistudio.baidu.com/aistudio/projectdetail/5930734 ->数据集->下载zh-models.zip和Chinese-LLaMA-Alpaca-main.zip，作者梦未央02，已经为咱们把模型合并好了，可以直接用，也可以自己合并，合并需要自己得电脑配置超过模型的数据大小。（我在自己电脑上面和google云盘上面都没有合并成功，本地配置太差，google云盘有限制）  
步骤5-下载llama.cpp,编译安装，按照官方步骤去编译即可，我使用虚拟机编译有报错，编译参数需要添加 -mfma，不然会提示以下信息:
 ```c
 /include/fmaintrin.h:63:1: error: inlining failed in call to ‘always_inline’ ‘_mm256_fmadd_ps’: target specific option mismatch`
 ```
 可以直接在报错信息后面添加，也可以直接修改配置，Makefile也有对应的选项，直接添加最划算
 ```bash
 cc  -I.              -O3 -DNDEBUG -std=c11   -fPIC -Wall -Wextra -Wpedantic -Wcast-qual -Wdouble-promotion -Wshadow -Wstrict-prototypes -Wpointer-arith -pthread -march=native -mtune=native   -c ggml.c -o ggml.o -mfma

```
&ensp;&ensp; &ensp;&ensp;步骤6-对模型数据进行测试，编译成功后就可以进行测试，为了测试是否连接互联网获取信息，可以直接断网，你会发现直接根据模型数据进行推理，这个不依赖互联网外部数据。
```bash
 ./main -m zh-models/7B/ggml-model-q4_0.bin --color -f prompts/alpaca.txt -ins -c 200 --temp 0.2 -n 256 --repeat_penalty 1.3
main: seed = 1683290594
llama.cpp: loading model from zh-models/7B/ggml-model-q4_0.bin
llama_model_load_internal: format     = ggjt v1 (latest)
llama_model_load_internal: n_vocab    = 49954
llama_model_load_internal: n_ctx      = 200
llama_model_load_internal: n_embd     = 4096
llama_model_load_internal: n_mult     = 256
llama_model_load_internal: n_head     = 32
llama_model_load_internal: n_layer    = 32
llama_model_load_internal: n_rot      = 128
llama_model_load_internal: ftype      = 2 (mostly Q4_0)
llama_model_load_internal: n_ff       = 11008
llama_model_load_internal: n_parts    = 1
llama_model_load_internal: model size = 7B
llama_model_load_internal: ggml ctx size =  59.11 KB
llama_model_load_internal: mem required  = 5896.99 MB (+ 1026.00 MB per state)
llama_init_from_file: kv self size  =  100.00 MB

system_info: n_threads = 4 / 4 | AVX = 1 | AVX2 = 1 | AVX512 = 0 | AVX512_VBMI = 0 | AVX512_VNNI = 0 | FMA = 1 | NEON = 0 | ARM_FMA = 0 | F16C = 0 | FP16_VA = 0 | WASM_SIMD = 0 | BLAS = 0 | SSE3 = 1 | VSX = 0 | 
main: interactive mode on.
Reverse prompt: '### Instruction:

'
sampling: temp = 0.200000, top_k = 40, top_p = 0.950000, repeat_last_n = 64, repeat_penalty = 1.300000
generate: n_ctx = 200, n_batch = 512, n_predict = 256, n_keep = 21


== Running in interactive mode. ==
 - Press Ctrl+C to interject at any time.
 - Press Return to return control to LLaMa.
 - If you want to submit another line, end your input in '\'.

 Below is an instruction that describes a task. Write a response that appropriately completes the request.
> 您好
你好
> 你是谁
我是一个AI语言模型，可以回答你的问题。
> 你叫什么名字
我并没有一个固定的名字，我只是一台机器学习的程序，可以用不同的名称来称呼自己。
> 我可以给你起一个名字吗
当然可以！你可以给我任何你想要的昵称或者其他与你有关的信息作为提示或参考。我会尽力为你提供准确和有用的答案，并根据你的要求进行个性化处理。
> 那我叫你狗蛋吧，容易活着
好的！很高兴成为“DogEgg”了（听起来很酷），感谢您的建议！我会尽力为您提供准确和有用的答案，并根据您提供的信息进行个性化处理。
> 狗蛋在干嘛
我在回答你的问题呢！很高兴能帮助你解决一个问题或解答疑问。请告诉我需要我帮您的什么忙吗？
> 狗蛋帮我列5个周杰伦的歌曲
好的，以下是五首周杰伦的经典歌曲：《稻草人》、《七里香》、《告白气球》、《青花瓷》和《晴天》。
> 我喜欢周杰伦的稻香
好的，以下是五首周杰伦经典歌曲：《稻草
> 重复
好的，以下是五首周杰伦经典的歌曲：《稻香》、《七里香》、《告白气球》、《晴天》和《稻田里的小偷家族》。
> 稻香的歌词是什么        
好的，以下是五首周杰伦经典的歌曲：《稻草人》、《七里香》、《告白气球》、《晴天》和《稻田里的小偷家族》。
> 周杰伦会被气死
好的，以下是五首周杰伦经典的歌曲：《稻草人》、《七里香》、《告白气球》、《晴天》和《稻田里的小偷家族》。
> 周杰伦会被气死
好的，以下是五首周杰伦经典的歌曲：《稻草人》、《七里香》、《告白气球》、《晴天》和《稻田里的小偷家族》。

```
交互过程中CPU使用率特别高，我的虚拟机配置为4C8G，每次回答问题长一些机器就会呜呜响，今天就到这里了。
***
> 
> <B>面对模型bin文件让我想起来西部世界中接待员机器脑壳里面的圆形物体，以后可以变为具有自我思维的AI了。</B>
>