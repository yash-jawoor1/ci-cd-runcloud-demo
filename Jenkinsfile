pipeline {
  agent any

  stages {
    stage('Checkout') {
      steps {
        checkout scm
      }
    }

    stage('React: Install dependencies') {
      steps {
        dir('frontend') {
          sh 'npm install'
        }
      }
    }

    stage('React: Build') {
      steps {
        dir('frontend') {
          sh 'npm run build'
        }
      }
    }

    stage('PHP: Syntax check') {
      steps {
        dir('backend') {
          sh 'php -l index.php'
        }
      }
    }
  }

  post {
    success {
      echo '✅ CI pipeline passed for both frontend and backend'
    }
    failure {
      echo '❌ CI pipeline failed'
    }
  }
}

