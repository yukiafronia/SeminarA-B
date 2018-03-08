using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace NeuralNetworkPrototype
{

    class TestCase
    {
        static void Main(string[] args) 
        {
            XOR();
        }

        static void XOR()
        {
            NeuralNetworkCore core = new NeuralNetworkCore(4, 4, 2, 2, 1);

            // 訓練用XORデータ入力＋出力（教師）
            core.output_in[0, 0] = 0.0; core.output_in[0, 1] = 0.0; core.teacher_signal[0, 0] = 0.0;
            core.output_in[1, 0] = 1.0; core.output_in[1, 1] = 0.0; core.teacher_signal[1, 0] = 1.0;
            core.output_in[2, 0] = 0.0; core.output_in[2, 1] = 1.0; core.teacher_signal[2, 0] = 1.0;
            core.output_in[3, 0] = 1.0; core.output_in[3, 1] = 1.0; core.teacher_signal[3, 0] = 0.0;

            // テスト用XOR入力
            core.output_in[4, 0] = 0.0; core.output_in[4, 1] = 0.0;
            core.output_in[5, 0] = 1.0; core.output_in[5, 1] = 0.0;
            core.output_in[6, 0] = 0.0; core.output_in[6, 1] = 1.0;
            core.output_in[7, 0] = 1.0; core.output_in[7, 1] = 1.0;

            // ニューラルネットワークを初期化
            core.Initialize();

            // 信号伝播と誤差逆伝播を10000回行う
            for (int i = 0; i < 10000; i++)
            {
                for (int j = 0; j < core.count_train; j++)
                {
                    core.ForwardPropagation(j);
                    core.BackPropagation(j);
                }
            }

            // 訓練データを信号伝播にかけて出力する
            for (int j = 0; j < core.count_test; j++)
            {
                core.ForwardPropagation(core.count_train + j);
                for (int k = 0; k < core.count_unit_in; k++)
                {
                    Console.Write(core.output_in[j, k]);
                    if (k != core.count_unit_in - 1) Console.Write(", ");
                }
                Console.WriteLine();
                for (int k = 0; k < core.count_unit_out; k++)
                {
                    Console.WriteLine(core.output_out[k]);
                }
                Console.WriteLine("-----------------------------");
            }

        }
    }
}