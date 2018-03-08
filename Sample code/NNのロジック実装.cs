using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace NeuralNetworkPrototype
{
    class NeuralNetworkCore : NeuralNetworkBase
    {
        /// <summary>
        /// ネットワークの土台を構築する
        /// </summary>
        /// <param name="Y1">訓練用データの数</param>
        /// <param name="Y2">テスト用データの数</param>
        /// <param name="Y3">入力層のユニット数</param>
        /// <param name="Y4">隠れ層のユニット数</param>
        /// <param name="Y5">出力層のユニット数</param>
        public NeuralNetworkCore(int Y1, int Y2, int Y3, int Y4, int Y5, double Y6=0.8, double Y7=0.75) : base(Y1, Y2, Y3, Y4, Y5, alpha:Y6, eta:Y7) { }

        // ネットワークを初期化する
        public override void Initialize()
        {
            Random Rnd = new Random();

            // 入力層->隠れ層の重みを乱数で初期化
            for (int i = 0; i < count_unit_hidden; i++)
            {
                for (int j = 0; j < count_unit_in; j++)
                {
                    weight_in_to_hidden[i,j] = Math.Sign(Rnd.NextDouble() - 0.5) * Rnd.NextDouble();
                }
                bias_hidden[i] = Math.Sign(Rnd.NextDouble() - 0.5) * Rnd.NextDouble();
            }

            // 隠れ層→出力層の重みを乱数で初期化
            for (int i = 0; i < count_unit_out; i++)
            {
                for (int j = 0; j < count_unit_hidden; j++)
                {
                    weight_hidden_to_out[i, j] = Math.Sign(Rnd.NextDouble() - 0.5) * Rnd.NextDouble();
                }
                bias_out[i] = Math.Sign(Rnd.NextDouble() - 0.5) * Rnd.NextDouble();
            }
        }

        /// <summary>
        /// 入力層->隠れ層の信号伝播
        /// </summary>
        /// <param name="dataIndex">訓練データのインデックス</param>
        public override void ForwardPropagation(int dataIndex)
        {
            double sum = 0.0;

            // 入力層->隠れ層への信号伝播
            for (int i = 0; i < count_unit_hidden; i++)
            {
                sum = 0.0;
                for (int j = 0; j < count_unit_in; j++)
                {
                    // 重みと入力層j番目のユニットの出力値をかけて足し合わせる
                    sum += weight_in_to_hidden[i, j] * output_in[dataIndex, j];
                }
                // バイアスを加えたsumを伝達関数に与えたものが隠れ層i番目のユニットの出力
                output_hidden[i] = sigmoid(sum + bias_hidden[i]);
            }

            // 隠れ層->出力層への信号伝播
            for (int i = 0; i < count_unit_out; i++)
            {
                sum = 0.0;
                for (int j = 0; j < count_unit_hidden; j++)
                {
                    sum += weight_hidden_to_out[i, j] * output_hidden[j];
                }
                output_out[i] = sigmoid(sum + bias_out[i]);
            }
        }

        /// <summary>
        /// 誤差逆伝播法を用いてネットワークを調整する
        /// </summary>
        /// <param name="dataIndex">訓練データのインデックス</param>
        public override void BackPropagation(int dataIndex) 
        {
            double sum = 0.0;
            double[] teacher_signal_out_to_hidden = new double[count_unit_out];
            double[] learn_signal_out_to_hidden = new double[count_unit_hidden];
            
            // 出力層の教師信号をすべてのユニットについて求める
            for (int i = 0; i < count_unit_out; i++)
            {
                teacher_signal_out_to_hidden[i] = (teacher_signal[dataIndex, i] - output_out[i]) * output_out[i] * (1.0 - output_out[i]);
            }

            // 出力層->隠れ層の重みの変化量を求める
            for (int i = 0; i < count_unit_hidden; i++)
            {
                sum = 0.0;
                for (int j = 0; j < count_unit_out; j++)
                {
                    weight__modify_hidden_to_out[j, i] = eta * teacher_signal_out_to_hidden[j] * output_hidden[i] + alpha * weight__modify_hidden_to_out[j, i];
                    weight_hidden_to_out[j, i] += weight__modify_hidden_to_out[j, i];
                    sum += teacher_signal_out_to_hidden[j] * weight_hidden_to_out[j, i];
                }
                // シグモイド関数の１次微分と掛け合わせる
                learn_signal_out_to_hidden[i] = output_hidden[i] * (1 - output_hidden[i]) * sum;
            }

            // 出力層のバイアスの変化量を求める
            for (int i = 0; i < count_unit_out; i++)
            {
                bias_modify_out[i] = eta * teacher_signal_out_to_hidden[i] + alpha * bias_modify_out[i];
                bias_out[i] += bias_modify_out[i];
            }

            // 隠れ層->入力層の重みの変化量を求める
            for (int i = 0; i < count_unit_in; i++)
            {
                for (int j = 0; j < count_unit_hidden; j++)
                {
                    weight_modify_in_to_hidden[j, i] = eta * learn_signal_out_to_hidden[j] * output_in[dataIndex, i] + alpha * weight_modify_in_to_hidden[j, i];
                    weight_in_to_hidden[j, i] += weight_modify_in_to_hidden[j, i];
                }
            }

            // 隠れ層のバイアスの変化量を求める
            for (int i = 0; i < count_unit_hidden; i++)
            {
                bias_modify_hidden[i] = eta * learn_signal_out_to_hidden[i] + alpha * bias_modify_hidden[i];
                bias_hidden[i] += bias_modify_hidden[i];
            }
        }

        public double sigmoid(double x)
        {
            return 1.0 / (1.0 + Math.Exp(-x));
        }

        public double tanh(double x) 
        {
            return Math.Tanh(x);
        }
    }
}