using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace NeuralNetworkPrototype
{
    abstract class NeuralNetworkBase
    {
        public int count_train;
        public int count_test;
        public int count_unit_in;
        public int count_unit_hidden;
        public int count_unit_out;
        public double alpha;
        public double eta;
        public double[,] output_in;
        public double[] output_hidden;
        public double[] output_out;
        public double[,] weight_in_to_hidden;
        public double[,] weight_hidden_to_out;
        public double[,] weight_modify_in_to_hidden;
        public double[,] weight__modify_hidden_to_out;
        public double[] bias_hidden;
        public double[] bias_out;
        public double[] bias_modify_hidden;
        public double[] bias_modify_out;
        public double[,] teacher_signal;

        /// <summary>
        /// ネットワークの土台を構築する
        /// </summary>
        /// <param name="count_train">訓練用データの数</param>
        /// <param name="count_test">テスト用データの数</param>
        /// <param name="count_unit_in">入力層のユニット数</param>
        /// <param name="count_unit_hidden">隠れ層のユニット数</param>
        /// <param name="count_unit_out">出力層のユニット数</param>
        public NeuralNetworkBase(int count_train, int count_test, int count_unit_in, int count_unit_hidden, int count_unit_out, double alpha, double eta)
        {
            this.count_train = count_train;
            this.count_test = count_test;
            this.count_unit_in = count_unit_in;
            this.count_unit_hidden = count_unit_hidden;
            this.count_unit_out = count_unit_out;

            this.output_in = new double[count_train + count_test, count_unit_in];
            this.output_hidden = new double[count_unit_hidden];
            this.output_out = new double[count_unit_out];

            this.weight_in_to_hidden = new double[count_unit_hidden, count_unit_in];
            this.weight_hidden_to_out = new double[count_unit_out, count_unit_hidden];
            this.weight_modify_in_to_hidden = new double[count_unit_hidden, count_unit_in];
            this.weight__modify_hidden_to_out = new double[count_unit_out, count_unit_hidden];

            this.bias_hidden = new double[count_unit_hidden];
            this.bias_out = new double[count_unit_out];
            this.bias_modify_hidden = new double[count_unit_hidden];
            this.bias_modify_out = new double[count_unit_out];
            this.teacher_signal = new double[count_train + count_test, count_unit_out];

            this.alpha = alpha;
            this.eta = eta;
        }

        public abstract void Initialize();
        public abstract void ForwardPropagation(int dataIndex);
        public abstract void BackPropagation(int dataIndex);
    }
}